function ellipsis(str1, str2)
{
	var outs = document.getElementsByClassName(str1);
	var i;
	for (i = 0; i < outs.length ; i ++) {
		var out = outs[i];
		var content = out.getElementsByTagName(str2)[0];
		var h = out.offsetHeight;
		while (content.offsetHeight > h) {
			content.innerHTML = content.innerHTML.replace(/(\s)*([a-zA-Z0-9]+|\W)(\.\.\.)?$/, "...");
		}
	}
}