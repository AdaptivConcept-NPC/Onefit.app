//<!-- Copyright 2006,2007 Bontrager Connection, LLC
// https://www.willmaster.com/
// Version: July 28, 2007
var cX = 0;
var cY = 0;
var rX = 0;
var rY = 0;
function UpdateCursorPosition(e) {
	cX = e.pageX;
	cY = e.pageY;
}
function UpdateCursorPositionDocAll(e) {
	cX = event.clientX;
	cY = event.clientY;
}
if (document.all) {
	document.onmousemove = UpdateCursorPositionDocAll;
} else {
	document.onmousemove = UpdateCursorPosition;
}
function AssignPosition(d) {
	if (self.pageYOffset) {
		rX = self.pageXOffset;
		rY = self.pageYOffset;
	} else if (document.documentElement && document.documentElement.scrollTop) {
		rX = document.documentElement.scrollLeft;
		rY = document.documentElement.scrollTop;
	} else if (document.body) {
		rX = document.body.scrollLeft;
		rY = document.body.scrollTop;
	}
	if (document.all) {
		cX += rX;
		cY += rY;
	}
	var newElem = document.getElementById(d);
	newElem.style.left = cX + 10 + "px";
	newElem.style.top = cY + 10 + "px";
}
function HideContent(d) {
	if (d.length < 1) {
		return;
	}
	document.getElementById(d).style.display = "none";
}
function ShowContent(d) {
	if (d.length < 1) {
		return;
	}
	var dd = document.getElementById(d);
	AssignPosition(dd);
	dd.style.display = "block";
}
function ReverseContentDisplay(d) {
	if (d.length < 1) {
		return;
	}
	var dd = document.getElementById(d);
	AssignPosition(dd);
	if (dd.style.display == "none") {
		dd.style.display = "block";
	} else {
		dd.style.display = "none";
	}
}
//-->

// create a new	div element styled as a marker on physical assessment panel
function createMarker() {
	g = document.createElement("div");
	randID = makeid(5);

	g.setAttribute("id", "marker-" + randID);
	g.setAttribute("class", "indication-marker");

	//
	/* <a onmouseover="ShowContent('marker-randID'); return true;"
    href="javascript:ShowContent('uniquename2')">
    [show, content has "hide" link]
    </a> */

	g.innerHTML = `
    <div class="marker-content">
        Content goes here. 
    </div>
    <a onmouseover="HideContent('marker-${randID}'); return true;"
    href="javascript:HideContent('marker-${randID}')">
        <span class="material-icons" style="font-size:20px!important;">cancel</span>
    </a>
    `;

	AssignPosition("marker-" + randID);
}

// creates a random id string. src: http://stackoverflow.com/questions/1349404/ddg#1349426
function makeid(length) {
	var result = "";
	var characters =
		"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	var charactersLength = characters.length;
	for (var i = 0; i < length; i++) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}
	return result;
}
