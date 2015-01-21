// JavaScript Document
var current = 0;
var done_array = new Array();
var need_array = new Array();
var title_array = new Array();
var content_array = new Array();
var link_array = new Array();
var num = 0;
function initProgress(link, done,  need, title, content) {
	addProgress(link, done,  need, title, content);
	setProgress(0);
}

function addProgress(link, done,  need, title, content) {
	done_array[num] = done;
	need_array[num] = need;
	title_array[num] = title;
	content_array[num] = content;
	link_array[num] = link;
	num ++;
}

function setProgress(i) {
	var totalWidth = document.getElementById("progress_bar").offsetWidth;
	if (need_array[i] <= 0 ) 
		progress = 1;
	else {
		var progress = done_array[i] / need_array[i];
		if (progress > 1)
			progress = 1;
	}
	var nowWidth = progress * totalWidth;

	document.getElementById("progress").style.marginLeft = nowWidth + "px";
	document.getElementById("progress_text").innerHTML = done_array[i] + "/" + need_array[i];
	document.getElementById("mask_title").innerHTML = "<a href=" + link_array[i] + ">" + title_array[i] + "</a>";
	document.getElementById("mask_content").innerHTML = "<a href=" + link_array[i] + ">" + content_array[i] + "</a>";

	ellipsis('mask_content', 'a');
}

function goNext(i) {
	document.getElementById('pic' + current).style.display= "none";
	document.getElementById('tag' + current).className = "";
	current = i;
	if (current>=4) current=0;
	document.getElementById('pic' + current).style.display= 'block';
	document.getElementById('tag' + current).className = "select";

	setProgress(current);
}
window.onload = function() 
{
	setInterval("goNext("+'current+1'+")",5000);
}