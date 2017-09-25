
//ShowFile Start


function MagnetRequest(paras,url){ 
	var paraString = url.substring(url.indexOf("?")+1,url.length).split("&"); 
	var paraObj = {} 
	for (i=0; j=paraString[i]; i++){ 
		paraObj[j.substring(0,j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=")+1,j.length); 
	} 
	var returnValue = paraObj[paras.toLowerCase()]; 
	return returnValue; 
}


function ShowMagnet(MagnetURI){
	MagnetDn=MagnetRequest("dn",MagnetURI)

	if (MagnetDn ==undefined || MagnetDn ==""){
		MagnetDn="下载地址 DOWNLOAD";
		XunLeiFilename="ORZAV.COM";
	}else{
		MagnetURI = MagnetURI.replace(MagnetDn,MagnetDn+"(ORZAV.COM)");
		XunLeiFilename=MagnetDn
	}

	document.write("<tr class=\"commonlistcell\"><td width=870><img src='wp-content/themes/ed2k/images/magnet.png' border=0 /> <a href=\""+MagnetURI+"\">"+MagnetDn+"</a></td><td width=80 align=center>"+FormatSize(MagnetRequest("xl",MagnetURI))+"</td></tr>")
}


function eD2kCheckAll(str,checked) {
    var a = document.getElementsByName(str);
    var n = a.length;

    for (var i = 0; i < n; i++) {
        a[i].checked = checked;
    }
    em_size(str);
}
function em_size(str) {
    var a = document.getElementsByName(str);
    var n = a.length;
    try {
        var input_checkall = document.getElementById("checkall_"+str);
        var size = 0;
        input_checkall.checked = true ;
        for (var i=0; i < n; i++) {
            if (a[i].checked) {
                var piecesArray = a[i].value.split( "|" );
                size += piecesArray[3]*1;
            } else {
                input_checkall.checked = false;
            }
        }
        test = document.getElementById("size_"+str);
        test.innerHTML = gen_size(size, 3, 1);
    } catch (e) {

    }
}
function gen_size(d,a,b){sep=Math.pow(10,b);a=Math.pow(10,a);retval=d;unit="Bytes";if(d>=a*1000000000){d=Math.round(d/(1099511627776/sep))/sep;unit="TB"}else{if(d>=a*1000000){d=Math.round(d/(1073741824/sep))/sep;unit="GB"}else{if(d>=a*1000){d=Math.round(d/(1048576/sep))/sep;unit="MB"}else{if(d>=a){d=Math.round(d/(1024/sep))/sep;unit="KB"}}}}return d+unit}



function download(str, i, first) {
    var a = document.getElementsByName(str);
    var n = a.length;

	//尝试使用activex方式批量新增下载
	try {
		var ed2k_links = '';
		var ax = new ActiveXObject("IE2EM.IE2EMUrlTaker");
		var emule_version = ax.GetEmuleVersion();
		if ('e' != emule_version.substr(0,1)) {
			throw {errorCode:'eMule not Installed.'};
		}
		for (var i = i; i < n; i++) {
			if(a[i].checked) {
				if (ed2k_links=='') {
					ed2k_links = a[i].value;
				} else {
					ed2k_links += "\n"+a[i].value;
				}
			}
		}
		ax.SendUrl(ed2k_links, 'dd', document.location);
		delete ax;
		return;
	} catch (e) {}

	if (!window.continueDown) {
		//使用最旧的方法来批量新增下载
		for (var i = i; i < n; i++) {
			if(a[i].checked) {
				window.location=a[i].value;
				if (first)
					timeout = 6000;
				else
					timeout = 500;
				i++;
				window.setTimeout("download('"+str+"', "+i+", 0)", timeout);
				break;
			}
		}
	} else {
		//使用稍微新一点的方法来批量新增下载
		for (var i = i; i < n; i++) {
			if(a[i].checked) {
				if(first){
					var k = i;
					var current_link = a[k].nextSibling;
					var multi_text = '';
					var tmp_counter = 0;
					var comma = '';
					while(true){
						if(a[k].checked && current_link){//如果是有效节点并且被选中
							if(current_link.href){
								if(current_link.href.indexOf('ed2k') !== 0){
									current_link = current_link.nextSibling;
									continue; 
								}
								if(tmp_counter > 7){//收集超过若干个有效链接后，退出
									multi_text += '<br />…………'; 
									break; 
								}
								var right_link = current_link;
								tmp_counter++;
								if (navigator.userAgent.toLowerCase().indexOf("msie")==-1) {
									multi_text += comma+current_link.text;
								}else{
									multi_text += comma+current_link.innerText;
								}
								comma = '<br />';
							}

							current_link = current_link.nextSibling;
						}else{//未被选中，或往下没有相邻节点了，那么切换到下个父节点
							if(++k >= n){//如果父节点也到底了，那么退出
								break; 
							}
							current_link = a[k].nextSibling;
						}
					}
					downPopup(right_link,multi_text);
				}

				continueDown(a[i].value);
				//window.location=a[i].value;
				if (first)
					timeout = 6000;
				else
					timeout = 500;
				i++;
				window.setTimeout("download('"+str+"', "+i+", 0)", timeout);
				break;
			}
		}
	}

}

function copy(str) {

    var a = document.getElementsByName(str);
    var n = a.length;
    var ed2kcopy = "";
    for (var i = 0; i < n; i++) {
        if(a[i].checked) {
            ed2kcopy += a[i].value;
            ed2kcopy += "\r\n";
        }
    }
    copyToClipboard(ed2kcopy);
}


function copyToClipboard(txt) {
	if(window.clipboardData) {
   		window.clipboardData.clearData();
   		window.clipboardData.setData("Text", txt);
	} else if(navigator.userAgent.indexOf("Opera") != -1) {
		window.location = txt;
	} else if (window.netscape) {
		try {
			netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
		} catch (e) {
			alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");
		}
		var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
		if (!clip)
			return;
		var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		if (!trans)
			return;
		trans.addDataFlavor('text/unicode');
		var str = new Object();
		var len = new Object();
		var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
		var copytext = txt;
		str.data = copytext;
		trans.setTransferData("text/unicode",str,copytext.length*2);
		var clipid = Components.interfaces.nsIClipboard;
		if (!clip)
			return false;
		clip.setData(trans,null,clipid.kGlobalClipboard);
	}
}


function CheckComment(FormName){

	UserEmail=FormName.UserEmail;
	UserPassword=FormName.UserPassword;
	
	if(typeof(UserEmail) != "undefined"){
		if(UserEmail.value.indexOf("@")<=0 || UserEmail.value.indexOf(".")<=0 || UserEmail.value.indexOf("@")>UserEmail.value.lastIndexOf(".")){
			alert('请正确输入你的Email帐号');
			UserEmail.focus();
			return false;
		}
	}
	if(typeof(UserPassword) != "undefined"){
		if(UserPassword.value=='' || UserPassword.value.length<6){
			alert('请输入你的密码(至少六位)');
			UserPassword.focus();
			return false;
		}
	}
	if(typeof(FormName.Verifycode) != "undefined"){
		if(FormName.Verifycode.value.length!=4){
			alert('请输入正确的验证码');
			FormName.Verifycode.select();
			return false;
		}
	}
	if(FormName.CommentBody.value==''){
		alert('请输入评论内容');
		FormName.CommentBody.focus();
		return false;
	}
	if(FormName.CommentBody.value.length>500){
		alert('评论内容最多只能输入500个字符');
		FormName.CommentBody.focus();
		return false;
	}
	return true;
}

//ShowFile End



//FileList
function chksearch(){
	if (document.searchForm.SearchWord.value.length<2){
		alert('请输入搜索关键词（不小于2个字符）');
		document.searchForm.SearchWord.focus();
		return false;
	}
	return true;
}

//UserPannel
function ShowPannel(btn,ajaxUrl){
	var idname = new String(btn.id);
	var s = idname.indexOf("_");
	var e = idname.lastIndexOf("_")+1;
	var tabName = idname.substr(0, s);
	var id = parseInt(idname.substr(e, 1));
	var tabNumber = btn.parentNode.childNodes.length;
	for(i=0;i<tabNumber;i++){
		document.getElementById(tabName+"_tab_"+i).style.display = "none";
		document.getElementById(tabName+"_btn_"+i).className = "";
	};
	document.getElementById(tabName+"_tab_"+id).style.display = "block";
	btn.className = "NowTag";
	if (ajaxUrl)Ajax_CallBack(false,"AjaxArea",ajaxUrl);
}

function $(id) {
	return document.getElementById(id);
}


//COOKIE Start
function getCookie(sName){
	var cookie = "" + document.cookie;
	var start = cookie.indexOf(sName);
	if (cookie == "" || start == -1) 
		return "";
	var end = cookie.indexOf(';',start);
	if (end == -1)
		end = cookie.length;
	return unescape(cookie.substring(start+sName.length + 1,end));
}
function setCookie(sName, value) {
	document.cookie = sName + "=" + escape(value) + ";path="+CookiePath+";";
}
function setCookieForever(sName, value) {
	var expdate = new Date();
	expdate.setFullYear(expdate.getFullYear() + 30);
	var DomainStr = CookieDomain ? " domain=" + CookieDomain+"; " : "";
	document.cookie = sName + "=" + escape(value) + ";path="+CookiePath+";"+DomainStr+"expires="+expdate.toGMTString()+";";
}
//COOKIE END



//全选复选框
function SelectAll(form){
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		if (e.name != 'chkall' && e.type=="checkbox" && e.checked!=form.chkall.checked){e.click();}
	}
}



/*显示验证码*/
function getCode() {
	if(document.getElementById("imgid"))
		document.getElementById("imgid").innerHTML = '<img src="VerifyCode.asp?t='+Math.random()+'" alt="点击刷新验证码" style="cursor:pointer;border:0;vertical-align:middle;" onclick="this.src=\'VerifyCode.asp?t=\'+Math.random()" />'
}
//效验验证码
function CheckVerifyCode(VerifyCode) {
	var patrn=/^\d+$/;		//纯数字
	if(!patrn.exec(VerifyCode)) {
		document.getElementById("checkVerifyCode").style.display="inline";
		document.getElementById("checkVerifyCode").innerHTML="x您没有输入验证码或输入有误";
		return;
	}
}


//Ajax Start
function Ajax_GetXMLHttpRequest() {
	if (window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	} 
	else if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	}
}
function Ajax_CallBack(FormName,ID,URL,IsAlert){
	var x = Ajax_GetXMLHttpRequest();
	var ID = document.getElementById(ID);
	x.open("POST",URL);
	x.setRequestHeader("REFERER", location.href);
	x.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	x.onreadystatechange = function(){if(x.readyState == 4 && x.status == 200){if(IsAlert){x.responseText?alert(x.responseText):alert('添加成功');}else if(ID){ID.innerHTML=x.responseText;}}}
	var encodedData=""
	if (document.forms.length > 0 && FormName) {
		var form = document.forms[FormName];
		for (var i = 0; i < form.length; ++i) {
			var element = form.elements[i];
			if (element.name) {
				var elementValue = null;
				if (element.nodeName == "INPUT") {
					var inputType = element.getAttribute("TYPE").toUpperCase();
					if (inputType == "TEXT" || inputType == "PASSWORD" || inputType == "HIDDEN") {
						elementValue = escape(element.value);
					} else if (inputType == "CHECKBOX" || inputType == "RADIO") {
						if (element.checked) {
							elementValue = escape(element.value);
						}
					}
				} else if (element.nodeName == "SELECT" || element.nodeName == "TEXTAREA") {
					elementValue = escape(element.value);
				}
				if (elementValue) {
					if(encodedData==""){
						encodedData = element.name + "=" + encodeURIComponent(elementValue);
					}
					else{
						encodedData += "&" + element.name + "=" + encodeURIComponent(elementValue);
					}
				}
			}
		}

	}
	x.send(encodedData);
}

//Ajax End

function voteComment(CommentID,vote){
	var url_string = 'Ajax.asp?menu=VoteComment&CommentID='+CommentID+'&Vote='+vote+'';
	var CommentSpanID="CommentReputation_"+CommentID;
	if(document.getElementById(CommentSpanID).className == 'watch-comment-voting-off'){
		return;
	}
	Ajax_CallBack(false,CommentSpanID,url_string,0)
	document.getElementById(CommentSpanID).innerHTML = "<img src=http://www.biaoqing.com/2000/Images/loading.gif>";
}

function updateCharCount(charCount_id, label_id, textArea) {
	var msg = new Object();
	msg["exceeded"] = "字符数超过限制：";
	msg["remaining"] = "剩余字符数："; 
	updateCharCount_js(charCount_id, label_id, textArea, 500, msg)
}
function updateCharCount_js(charCount_id,label_id,textArea,maxChars,messages){
	if(textArea.value.length>maxChars){
		if(document.getElementById(label_id).innerHTML!=messages["exceeded"]){
		document.getElementById(label_id).innerHTML=messages["exceeded"];
		document.getElementById(label_id).className = 'F00';
	}
	document.getElementById(charCount_id).value=textArea.value.length-maxChars;
	}else{
		if(document.getElementById(label_id).innerHTML!=messages["remaining"]){
			document.getElementById(label_id).innerHTML=messages["remaining"];
		document.getElementById(label_id).className = '';
		}
		document.getElementById(charCount_id).value=maxChars-textArea.value.length;
	}
}

function quickReplyForm(FileID,CommentID,CommentUser){
	var innerHTMLContent='\
	<form name="quickform" method="post" action="?menu=AddComment" onsubmit="return chkbodylen(this)">\
		<input type="hidden" name="FileID" value="'+FileID+'" />\
		<textarea rows="5" cols="80" name="CommentBody" onkeyup="updateCharCount(\'charCountcomment_'+CommentID+'\', \'maxCharLabel_'+CommentID+'\', this);" onpaste="updateCharCount(\'charCountcomment_'+CommentID+'\', \'maxCharLabel_'+CommentID+'\', this);" oninput="updateCharCount(\'charCountcomment_'+CommentID+'\', \'maxCharLabel_'+CommentID+'\', this);">回复 '+CommentUser+'：</textarea>\
		<br/>\
		<input type="submit" value=" 回复 " /> <input type="button" value=" 放弃 " onclick="quickReplyForm(\''+FileID+'\',\''+CommentID+'\',\''+CommentUser+'\')" /> <span id="maxCharLabel_'+CommentID+'">剩余字符数：</span><input readonly="true" class="watch-comment-char-count" id="charCountcomment_'+CommentID+'" value="500" type="text">\
	</form>';

	var TempQuickReplayTD=document.getElementById("QuickReplayTD_"+CommentID);
	if (TempQuickReplayTD.style.display == 'none'){
		TempQuickReplayTD.innerHTML = innerHTMLContent;
		TempQuickReplayTD.style.display = 'block';
	}
	else{
		TempQuickReplayTD.innerHTML = '';
		TempQuickReplayTD.style.display = 'none';
	}
}

function chkbodylen(form){
	if (form.CommentBody.value.length>500){
		alert('评论内容最多只能输入500个字符');
		form.CommentBody.focus();
		return false;
	}
	if(form.CommentBody.value==''){
		alert('请输入评论内容');
		form.CommentBody.focus();
		return false;
	}
	return true;
}

//其他域名自动跳转到ed2000.com
//if (location.hostname != "www.ed2000.com"){
//top.location.href = "http://www.ed2000.com"+location.pathname+location.search;  
//}


function SnashHTML(URL){
	var x = Ajax_GetXMLHttpRequest();
	x.open("get",URL,false);
	x.onreadystatechange = function(){if(x.readyState == 4 && x.status == 200){alert(x.responseBody);}}
	x.send(null);
}



var UserAgent = navigator.userAgent.toLowerCase();
var ie4=document.all&&UserAgent.indexOf("opera")==-1
var ns6=document.getElementById&&!document.all

//XmlDom Start
var XmlDom;
function GetXmlDom() {
	if (window.ActiveXObject) {//IE浏览器
		return new ActiveXObject("Microsoft.XMLDOM");
	}
	else if (document.implementation && document.implementation.createDocument) { //其它浏览器
		return document.implementation.createDocument("","",null);
	}
}
function ReadXMLFile(xmlFilePath){	
	if((UserAgent.indexOf("chrome")>-1)){//chrome
		var xmlObj = Ajax_GetXMLHttpRequest();
		xmlObj.onreadystatechange = function(){
			if(xmlObj.readyState == 4 && xmlObj.status == 200){
				XmlDom = xmlObj.responseXML;
			}
		}
		xmlObj.open ('GET', xmlFilePath, false);
		xmlObj.send(null);
	}
	else {//other browser
		XmlDom = GetXmlDom();
		XmlDom.async = false;
		XmlDom.load(xmlFilePath);
	}
}
function GetNodeValue(objXmlElement)
{
	if(window.ActiveXObject) {	//IE浏览器
		return objXmlElement.text;
	}
	else if(window.XMLHttpRequest) {  //其它浏览器
		try {
			return objXmlElement.firstChild.nodeValue;
		}
		catch(ex) {
			return "";
		}
	}
}



function FormatSize(ByteSize){
	if (ByteSize >= 1099511627776){
		ByteSize = Math.round( ByteSize / 1099511627776 * 100)/100+" TB"
	}else if (ByteSize>=1073741824){
		ByteSize = Math.round( ByteSize / 1073741824 * 100)/100+" GB"
	}else if (ByteSize>=1048576){
		ByteSize = Math.round( ByteSize / 1048576 * 100)/100+" MB"
	}else if (ByteSize>=1024){
		ByteSize = Math.round( ByteSize / 1024 * 100)/100+" KB"
	}else if (ByteSize>0){
		ByteSize=ByteSize+" 字节"
	}else{
		ByteSize="<img src='/wp-content/themes/ed2k/images/magnet-icon-14w-14h.gif'>";
	}
	return ByteSize; 
}

