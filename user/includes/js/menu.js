// JavaScript Document

//Contents for about menu
var aboutmenu=new Array()
aboutmenu[0]='<a href="/about/project/">The Project</a>'
aboutmenu[1]='<a href="/about/science/">The Science</a>'
aboutmenu[2]='<a href="/about/science/advanced.php">Advanced Concepts</a>'
aboutmenu[3]='<a href="/about/project/news.php">News / Newsletters</a>'
aboutmenu[4]='<a href="/about/project/staff.php">Staff</a>'
aboutmenu[5]='<a href="/about/project/papers.php">Papers</a>'
aboutmenu[6]='<a href="/about/project/history.php">History</a>'
aboutmenu[7]='<a href="/about/glossary.php">Glossary</a>'

//Contents for join menu
var joinmenu=new Array()
joinmenu[0]='<a href="/join/gettingstarted.php">Getting Started</a>'
joinmenu[1]='<a href="/join/rulespolicies.php">Rules and Policies</a>'
joinmenu[2]='<a href="/account/create_form.php">Create an Account</a>'

//Contents for community menu
var communitymenu=new Array()
communitymenu[0]='<a href="/account/">My Account</a>'
communitymenu[1]='<a href="/community/forum/">Message Boards</a>'
communitymenu[2]='<a href="/community/profile_menu.php">Profiles</a>'
communitymenu[3]='<a href="/community/user_search.php">User Search</a>'
communitymenu[4]='<a href="/community/team/">Teams</a>'
communitymenu[5]='<a href="/community/top_users.php">Top Participants</a>'
communitymenu[6]='<a href="/community/top_hosts.php">Top Computers</a>'
communitymenu[7]='<a href="/community/top_teams.php">Top Teams</a>'
communitymenu[8]='<a href="/community/statistics.php">More Statistics</a>'
communitymenu[9]='<a href="/community/bestresults.php">Best Results</a>'

//Contents for status menu
var statusmenu=new Array()
statusmenu[0]='<a href="/status/">Server Status</a>'
statusmenu[1]='<a href="/status/apps.php">Applications</a>'
statusmenu[2]='<a href="/status/distribution.php">Distribution</a>'

//Contents for support menu
var supportmenu=new Array()
supportmenu[0]='<a href="/support/faq.php">FAQ</a>'
supportmenu[1]='<a href="/support/language_select.php">Language</a>'
supportmenu[2]='<a href="/support/bbcode.php">BBCode Tags</a>'
supportmenu[3]='<a href="/support/html.php">HTML Tags</a>'
supportmenu[4]='<a href="/support/otherresources.php">Other Resources</a>'

var menuwidth='165px' //default menu width
var menubgcolor='white'  //menu bgcolor
var disappeardelay=250  //menu disappear speed onMouseout (in miliseconds)
var hidemenu_onclick="yes" //hide menu when user clicks within menu?

/////No further editting needed

var ie4=document.all
var ns6=document.getElementById&&!document.all

if (ie4||ns6)
	document.write('<div id="dropmenudiv" style="visibility:hidden;width:'+menuwidth+';background-color:'+menubgcolor+'" onMouseover="clearhidemenu()" onMouseout="dynamichide(event)"></div>')

function getposOffset(what, offsettype){
	var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
	var parentEl=what.offsetParent;
	while (parentEl!=null){
		totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
		parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}


function showhide(obj, e, visible, hidden, menuwidth){
	if (ie4||ns6)
		dropmenuobj.style.left=dropmenuobj.style.top="-500px"
	if (menuwidth!=""){
		dropmenuobj.widthobj=dropmenuobj.style
		dropmenuobj.widthobj.width=menuwidth
	}
	if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
		obj.visibility=visible
	else if (e.type=="click")
		obj.visibility=hidden
}

function iecompattest(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
	var edgeoffset=0
	if (whichedge=="rightedge"){
		var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
		dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
		if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
			edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
	}
	else{
		var topedge=ie4 && !window.opera? iecompattest().scrollTop : window.pageYOffset
		var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
		dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
		if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure){ //move up?
			edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
			if ((dropmenuobj.y-topedge)<dropmenuobj.contentmeasure) //up no good either?
				edgeoffset=dropmenuobj.y+obj.offsetHeight-topedge
		}
	}
	return edgeoffset
}

function populatemenu(what){
	if (ie4||ns6)
		dropmenuobj.innerHTML=what.join("")
}


function dropdownmenu(obj, e, menucontents, menuwidth){
	if (window.event) event.cancelBubble=true
	else if (e.stopPropagation) e.stopPropagation()
		clearhidemenu()
	dropmenuobj=document.getElementById? document.getElementById("dropmenudiv") : dropmenudiv
	populatemenu(menucontents)

	if (ie4||ns6){
		showhide(dropmenuobj.style, e, "visible", "hidden", menuwidth)
		dropmenuobj.x=getposOffset(obj, "left")
		dropmenuobj.y=getposOffset(obj, "top")
		dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
		dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px"
	}

	return clickreturnvalue()
}

function clickreturnvalue(){
	if (ie4||ns6) return false
	else return true
}

function contains_ns6(a, b) {
	while (b.parentNode)
		if ((b = b.parentNode) == a)
			return true;
	return false;
}

function dynamichide(e){
	if (ie4&&!dropmenuobj.contains(e.toElement))
		delayhidemenu()
	else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
		delayhidemenu()
}

function hidemenu(e){
	if (typeof dropmenuobj!="undefined"){
		if (ie4||ns6)
			dropmenuobj.style.visibility="hidden"
	}
}

function delayhidemenu(){
	if (ie4||ns6)
		delayhide=setTimeout("hidemenu()",disappeardelay)
}

function clearhidemenu(){
	if (typeof delayhide!="undefined")
	clearTimeout(delayhide)
}

if (hidemenu_onclick=="yes")
	document.onclick=hidemenu
