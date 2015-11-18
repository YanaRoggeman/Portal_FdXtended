// AJAX
var qos = false;
var regprogress;
var httpBwGraph;
var httpSessions;
//only for admin GUI because there we can click multiple IP's but we only need to show the graph for 1 IP
var current_ip = "";
//external users
var external_device="";

/* --------------------------------------------------- */
/* ----------------- STATUS INFO --------------------- */
/* --------------------------------------------------- */

// How fast does the status data needs to be refreshed /
var refreshRateStatus = 10000;
var retryIfFails = 5;
var loadError = "Loading Failed";

/* --- */
// Divs the info will be set to if not empty
var divsUserData = {
    timeLeft_sec:null,
    totalTime_sec:null,
    timeLeftText:null,
    startTime:null,
    endTime:null,

    volumeDownLeft:null,
    percentVolumeDown:null,
    totalVolumeDown:null,
    volumeDownText:null,

    volumeUpLeft:null,
    percentVolumeUp:null,
    totalVolumeUp:null,
    volumeUpText:null,

    status:null,
    plan_name:null,
    plan_description:null,
    plan_price:null,

    pms_user:null,

    loading:null
};
var statusRetry = 0;
var statusRetryLoadingTime = 200;

function RefreshStatusData(sessionID){
    GetStatus(sessionID);
    setTimeout("RefreshStatusData('"+sessionID+"')", refreshRateStatus);
}


function GetStatus(sessionid)
{
    try
    {
        var timeleft = (divsUserData.timeLeft_sec != null) || (divsUserData.timeLeftText != null);
        var voldown = divsUserData.volumeDownLeft != null || divsUserData.volumeDownText != null || divsUserData.totalVolumeDown != null || divsUserData.percentVolumeDown != null;
        var volup = divsUserData.volumeUpLeft != null || divsUserData.volumeUpText != null || divsUserData.totalVolumeUp != null || divsUserData.percentVolumeUp != null;
        var status = true;//divsUserData.status != null;          //Set As true for loading
        var plan_name = divsUserData.plan_name != null;
        var plan_description = divsUserData.plan_description != null;
        var plan_price = divsUserData.plan_price != null;

        // branch for native XMLHttpRequest object
        if (window.XMLHttpRequest)
        {
            regprogress = new XMLHttpRequest();
            regprogress.onreadystatechange = function(){SetStatus(sessionid)};
            regprogress.open("GET", "../hsm/ajax_status.php?time="+timeleft+"&voldown="+voldown+"&volup="+volup+"&status="+status+"&plan_name="+plan_name+"&plan_description="+plan_description+"&plan_price="+plan_price+(sessionid!=""?"&sessionid="+sessionid:""), true);
            regprogress.send(null);
        }
        else if (window.ActiveXObject)
        {
            regprogress = new ActiveXObject("Microsoft.XMLHTTP");
            regprogress.onreadystatechange =  function(){SetStatus(sessionid)};
            regprogress.open("GET", "../hsm/ajax_status.php?time="+timeleft+"&voldown="+voldown+"&volup="+volup+"&status="+status+"&plan_name="+plan_name+"&plan_description="+plan_description+"&plan_price="+plan_price+(sessionid!=""?"&sessionid="+sessionid:""), true);
            regprogress.send();
        }
    }
    catch(e){ }
}

function SetStatus(sessionid){
    try{
        if(regprogress.readyState == 4 && regprogress.status == 200){
            response = regprogress.responseXML.documentElement;

            var status = response.getElementsByTagName('status')[0].firstChild.data;
            if(status == "Online" && divsUserData.status != null) {
                divsUserData.status.innerHTML = status;

            /* IF LOADING - CALL FAILED */
            }else if(status == "Offline"){
                if(statusRetry < retryIfFails) {
                    if (divsUserData.loading != null)
                        divsUserData.loading.innerHTML = "<img src='img/loading.gif' alt='...'>";

                    statusRetry++;
                    setTimeout("RefreshStatusData('" + sessionid + "')", statusRetryLoadingTime);
                }else{
                    if (divsUserData.loading != null)
                        divsUserData.loading.innerHTML = loadError;
                }
                return;
            }
            /* END LOADING */


            if(divsUserData.plan_name != null && response.getElementsByTagName('plan_name')[0] != null && response.getElementsByTagName('plan_name')[0].firstChild != null)
                divsUserData.plan_name.innerHTML = response.getElementsByTagName('plan_name')[0].firstChild.data;

            if(divsUserData.plan_description != null && response.getElementsByTagName('plan_description')[0] != null && response.getElementsByTagName('plan_description')[0].firstChild != null) {
                divsUserData.plan_description.innerHTML = response.getElementsByTagName('plan_description')[0].firstChild.data;
            }

            if(divsUserData.plan_price != null && response.getElementsByTagName('plan_price')[0] != null && response.getElementsByTagName('plan_price')[0].firstChild != null)
                divsUserData.plan_price.innerHTML = response.getElementsByTagName('plan_price')[0].firstChild.data;

            if(divsUserData.volumeDownLeft != null && response.getElementsByTagName('volume_down_left')[0] != null && response.getElementsByTagName('volume_down_left')[0].firstChild != null) {
                var volume_down_left = response.getElementsByTagName('volume_down_left')[0].firstChild.data;
                divsUserData.volumeDownLeft.innerHTML = volume_down_left;
            }

            if(divsUserData.totalVolumeDown != null && response.getElementsByTagName('total_volume_down')[0] != null && response.getElementsByTagName('total_volume_down')[0].firstChild != null) {
                var total_volume_down = response.getElementsByTagName('total_volume_down')[0].firstChild.data;
                divsUserData.totalVolumeDown.innerHTML = total_volume_down;
            }

            if(divsUserData.volumeDownText != null && response.getElementsByTagName('volume_down_text')[0] != null && response.getElementsByTagName('volume_down_text')[0].firstChild != null) {
                divsUserData.volumeDownText.innerHTML = response.getElementsByTagName('volume_down_text')[0].firstChild.data;
            }

            if(divsUserData.percentVolumeDown != null && response.getElementsByTagName('')[0] != null && volume_down_left != null && total_volume_down != null)
                divsUserData.percentVolumeDown.innerHTML = Math.round((volume_down_left / total_volume_down)*100) + "%";

            if(divsUserData.totalVolumeUp != null && response.getElementsByTagName('total_volume_up')[0] != null && response.getElementsByTagName('total_volume_up')[0].firstChild != null) {
                var total_volume_up = response.getElementsByTagName('total_volume_up')[0].firstChild.data;
                divsUserData.totalVolumeUp.innerHTML = total_volume_up;
            }

            if(divsUserData.volumeUpLeft != null && response.getElementsByTagName('volume_up_left')[0] != null && response.getElementsByTagName('volume_up_left')[0].firstChild != null) {
                    var volume_up_left = response.getElementsByTagName('volume_up_left')[0].firstChild.data;
                    divsUserData.volumeUpLeft.innerHTML = volume_up_left;
            }

            if(divsUserData.volumeUpText != null && response.getElementsByTagName('volume_up_text')[0] != null && response.getElementsByTagName('volume_up_text')[0].firstChild != null) {
                divsUserData.volumeUpText.innerHTML = response.getElementsByTagName('volume_up_text')[0].firstChild.data;
            }

            if(divsUserData.percentVolumeUp != null && response.getElementsByTagName('volume_down_left')[0] != null && volume_up_left != null && total_volume_up != null){
                divsUserData.percentVolumeUp.innerHTML = Math.round((volume_up_left / total_volume_up)*100) + "%";
            }

            if(divsUserData.timeLeft_sec != null && response.getElementsByTagName('timeleft')[0] != null && response.getElementsByTagName('timeleft')[0].firstChild != null){
                divsUserData.timeLeft_sec.innerHTML = SecondsToTime(response.getElementsByTagName('timeleft')[0].firstChild.data);
            }

            if(divsUserData.totalTime_sec != null && response.getElementsByTagName('total_time')[0] != null && response.getElementsByTagName('total_time')[0].firstChild != null) {
                divsUserData.totalTime_sec.innerHTML = SecondsToTime(response.getElementsByTagName('total_time')[0].firstChild.data);
            }

            if(divsUserData.timeLeftText != null && response.getElementsByTagName('timeleft_text')[0] != null && response.getElementsByTagName('timeleft_text')[0].firstChild != null){
                divsUserData.timeLeftText.innerHTML = response.getElementsByTagName('timeleft_text')[0].firstChild.data;
            }

            if(divsUserData.startTime != null && response.getElementsByTagName('start_time')[0] != null && response.getElementsByTagName('start_time')[0].firstChild != null)
                divsUserData.startTime.innerHTML = UnixToDate(response.getElementsByTagName('start_time')[0].firstChild.data);

            if(divsUserData.endTime != null) {
                if (response.getElementsByTagName('end_time')[0] != null && response.getElementsByTagName('end_time')[0].firstChild != null) {
                    divsUserData.endTime.innerHTML = UnixToDate(response.getElementsByTagName('end_time')[0].firstChild.data);
                }else if(response.getElementsByTagName('start_time')[0] != null && response.getElementsByTagName('start_time')[0].firstChild != null){
                    divsUserData.endTime.innerHTML = "∞";
                }
            }

            if(divsUserData.pms_user != null){
                divsUserData.pms_user.innerHTML = response.getElementsByTagName('pms_user')[0].firstChild.data;
            }

        }
    }catch(e){
        document.getElementById("plan_description").innerHTML = "something wrong " + e;
    }
}

function SecondsToTime(time){
    if(time == -1) return "∞";
    time = Math.floor(time);
    var hours = "0"+ Math.floor(time/ 3600);
    var min = "0" + Math.floor((time - hours * 3600) / 60);
    var sec = "0" + Math.floor(time - (hours*3600) - (min * 60));

    return (hours.substr(-2)+":"+min.substr(-2)+":"+sec.substr(-2));
}

function UnixToDate(unixDate){
    var date = new Date(unixDate*1000);
    var day = "0" + date.getDate();
    var month = "0" + date.getMonth();
    var year = date.getFullYear();
    var hours = date.getHours();
    var minutes = "0" + date.getMinutes();
    var seconds = "0" + date.getSeconds();

    return (day.substr(-2)+"/"+ month.substr(-2)+"/"+year+" "+ hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2));
}

/* --------------------------------------------------- */
/* ----------------- BANDWIDTH GRAPH ----------------- */
/* --------------------------------------------------- */

// Color of the graph                   |
var graphColor = '#D14D12';
// Color of the borders                 |
var canvasBorderColor = "#E8E8FF";
// How fast the graph will get new data |
var refreshRateGraph = 2000;
// Fontsize of text on the canvas       |
var fontSize = 15;

/* --- */
var bandwidhtCanvas;
var canvasLayout;
var height; //  bandwidhtCanvas.height;
var width;  // bandwidhtCanvas.width;
var canvasPaddingLeft = fontSize * 9;
var canvasPaddingBottomTop = fontSize * 3;
var speedText = "Kbps";
var limit;

function SetBandwidthCanvas(divName){
    bandwidhtCanvas = document.getElementById(divName);
}

function RefreshBandwidth(sessionID){
    if(bandwidhtCanvas != null){
         LoadGraphData(sessionID);
        setTimeout("RefreshBandwidth('"+sessionID+"')", refreshRateGraph);
    }
}

function LoadGraphData(sessionid){
    try{
        if(arguments[1] != null) var ip = arguments[1];
        else var ip = "";
        // branch for native XMLHttpRequest object
        if (window.XMLHttpRequest) {
            httpBwGraph = new XMLHttpRequest();
            httpBwGraph.onreadystatechange = SetData;
            httpBwGraph.open("GET", "../hsm/ajax_status.php?type=bandwidth"+(sessionid!=""?"&sessionid="+sessionid:"")+(ip!=""?"&ip="+ip:"")+(qos?"&qos=true":"")+(external_device!=""?"&external="+external_device:""), true);
            httpBwGraph.send(null);
            // branch for IE/Windows ActiveX version
        } else if (window.ActiveXObject) {
            httpBwGraph = new ActiveXObject("Microsoft.XMLHTTP");
            if (httpBwGraph) {
                httpBwGraph.onreadystatechange = SetData;
                httpBwGraph.open("GET", "../hsm/ajax_status.php?type=bandwidth" + (sessionid != "" ? "&sessionid=" + sessionid : "") + (ip != "" ? "&ip=" + ip : "") + (qos ? "&qos=true" : "") + (external_device != "" ? "&external=" + external_device : ""), true);
                httpBwGraph.send();
            }
        }
    }catch(e){
        bandwidhtCanvas.innerHTML = "Something went wrong";
    }
}

function SetData(){
    if(httpBwGraph.readyState == 4 && httpBwGraph.status == 200){
        var response = httpBwGraph.responseXML.documentElement;
        try{
            var data = response.getElementsByTagName('bandwidth_data')[0].firstChild.data;
            var ip = response.getElementsByTagName('ip')[0].firstChild.data;
            if(current_ip != null || ip != null) {
                CreateGraph(data);
            }
        }catch(e){
            document.getElementById("error").innerHTML = e;
        }
    }
}

/* --- Draw the data --- */
function CreateGraph(data){

    bandwidhtCanvas.style.display = "inline";
    InitCanvas();

    var values = data.split(',');
    var max = GetMaxValue(values);

    if(max>1024)
    {
        speedText = "Mbps";
        values = ConvertToMbps(values);
        max = GetMaxValue(values);
    }
    else speedText = "Kbps";

    limit = max *1.1;

  //  ClearGraph();
    PaintLines();
    PaintGraph(values,max);
}

function PaintGraph(values,max)
{
    canvasLayout.fillStyle   = graphColor;
    canvasLayout.textAlign="left";

    //get width of graph to paint
    var barWidth = (width-canvasPaddingLeft) / values.length ;
    var barHeight = (height- (canvasPaddingBottomTop*2)) / limit;

    // Paint
    for(var i=0;i<values.length;i++)
    {
        try
        {
            var thisHeight =  values[i]*barHeight;
            var x = (i * barWidth);
            var y = ((height-thisHeight) - canvasPaddingBottomTop);

            canvasLayout.fillRect((x+canvasPaddingLeft), y ,barWidth,thisHeight );
        }
        catch(Ex){}
    }
}

function PaintLines()
{
    //lines
    PaintCanvasBorders();
    PaintCanvasGridLines();
}

function InitCanvas()
{
    if(canvasLayout == null)
        canvasLayout = bandwidhtCanvas.getContext("2d");

//    bandwidhtCanvas.style.width = bandwidhtCanvas.offsetWidth;
    bandwidhtCanvas.style.height = bandwidhtCanvas.offsetHeight;

    bandwidhtCanvas.width = bandwidhtCanvas.offsetWidth *2;
    bandwidhtCanvas.height = bandwidhtCanvas.offsetHeight *2;

    width = bandwidhtCanvas.width;
    height = bandwidhtCanvas.height;
}

function ConvertToMbps(data)
{
    for(var i=0;i<data.length;i++)
    {
        data[i] = Math.round((data[i]/1024)*100 )/100;
    }

    return data;
}

function GetMaxValue(values)
{
    var max = 0;
    for(var i=0;i<values.length;i++)
    {
        if(parseFloat(values[i]) > max) max = values[i];
    }

    return max;
}

function PaintCanvasBorders()
{
    canvasLayout.strokeStyle  = canvasBorderColor;
    canvasLayout.beginPath();
    canvasLayout.moveTo(0,0);
    canvasLayout.lineTo(0, bandwidhtCanvas.height);
    canvasLayout.lineTo(bandwidhtCanvas.width,bandwidhtCanvas.height);
    canvasLayout.lineTo(bandwidhtCanvas.width,0);
    canvasLayout.lineTo(0, 0);
    canvasLayout.stroke();
    canvasLayout.closePath();
}

function PaintCanvasGridLines()
{
    canvasLayout.strokeStyle  = canvasBorderColor;
    if(bandwidhtCanvas.style.color != "undefined") canvasLayout.fillStyle = bandwidhtCanvas.style.color;
    canvasLayout.font = fontSize+"pt Arial";
    /*canvasLayout.font = (bandwidhtCanvas.style.fontWeight=="bold"?"bold ":"")
                +(bandwidhtCanvas.style.fontStyle=="italic"?"italic ":"")
                + "35pt"
                +" "
                +bandwidhtCanvas.style.fontFamily;
    */

    // y-as
    canvasLayout.beginPath();
    var begin = height - canvasPaddingBottomTop;
    var between = (begin - canvasPaddingBottomTop) / 10;

    var betweenSpeed = limit / 10;

    //18px per line (text)
    var toShow =  Math.round(11/ (height/18) ) ;
    if(toShow<=0)toShow =1;

    canvasLayout.textAlign="right";
    for(var i=0;i<10;i++)
    {
        canvasLayout.moveTo(canvasPaddingLeft,(begin - (i*between) ));
        canvasLayout.lineTo(width,(begin - (i*between)));

        if(i % toShow == 0) canvasLayout.fillText( (i*betweenSpeed).toFixed(1) +speedText,(canvasPaddingLeft-7),(begin - (i*between) ));
    }

    //canvasLayout.fillText( (10*betweenSpeed).toFixed(1) +speedText,(canvasPaddingLeft-7),(begin - (10*between) ));
    canvasLayout.stroke();
    canvasLayout.closePath();

    //x as
    canvasLayout.textAlign="right";
    canvasLayout.fillText("0\"",width - 2,height-(canvasPaddingBottomTop - fontSize*2));
    canvasLayout.textAlign="right";
    canvasLayout.fillText("60\"",(width/2)+(canvasPaddingLeft/2),height-(canvasPaddingBottomTop - fontSize*2));
    canvasLayout.textAlign="left";
    canvasLayout.fillText("120\"",canvasPaddingLeft,height-(canvasPaddingBottomTop - fontSize*2));

}

/* --------------------------------------------------- */
/* -------------------- SESSIONS --------------------- */
/* --------------------------------------------------- */

// How fast do the sessions need to be refreshed ? ms  /
var refreshRateSessions = 15000;
// Only show the last x sessions
var maxShownSessions = 5;

/* --- */
var sort = "start";
var sort_type = "DESC";
var sessionsDiv = null;

function SetSessionDivs(nameDiv, nameLoadingDiv){
    SetSessionsDiv(nameDiv);
    SetSessionLoadingDiv(nameLoadingDiv);
}
function SetSessionsDiv(nameDiv){
    sessionsDiv = document.getElementById(nameDiv);
}
function SetSessionLoadingDiv(nameLoadingDiv){
    sessions_loading_div = document.getElementById(nameLoadingDiv);
}

function RefreshSessions(sessionid)
{

    if(sessionsDiv != null)
    {
       /* if(sessionsDiv.innerHTML=="")
            setStatusLoading(sessions_loading_div.name,sessionsDiv);*/
        LoadSessionData(sessionid);
        setTimeout("RefreshSessions('"+sessionid+"')",refreshRateSessions);
    }
}

function LoadSessionData(sessionid)
{
    try
    {
        // branch for native XMLHttpRequest object
        if (window.XMLHttpRequest) {
            httpSessions = new XMLHttpRequest();
            httpSessions.onreadystatechange = SetSessions;
            httpSessions.open("GET", "../hsm/ajax_status.php?type=sessions&sort="+sort+"&max_sessions="+maxShownSessions+"&sort_type="+sort_type+(sessionid!=""?"&sessionid="+sessionid:""), true);
            httpSessions.send(null);
            // branch for IE/Windows ActiveX version
        } else if (window.ActiveXObject) {
            httpSessions = new ActiveXObject("Microsoft.XMLHTTP");
            if (httpSessions) {
                httpSessions.onreadystatechange = SetSessions;
                httpSessions.open("GET", "../hsm/ajax_status.php?type=sessions&sort="+sort+"&max_sessions="+maxShownSessions+"&sort_type="+sort_type+(sessionid!=""?"&sessionid="+sessionid:""), true);
                httpSessions.send();
            }
        }
    }
    catch(e){
        sessionsDiv.innerHTML = e.error;
    }
}

function SetSessions()
{
    if (httpSessions.readyState == 4 && httpSessions.status == 200)
    {
        if(sessionsDiv != null) {
            sessionsDiv.innerHTML = httpSessions.responseText;
        }
    }
}

/* Do NOT change the name of this function ! */
function session_sort(so,so_type,sessionid)
{
    sort = so;
    sort_type = so_type;
    LoadSessionData(sessionid);
}