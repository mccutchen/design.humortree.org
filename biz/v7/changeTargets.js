function changeTargets()
{
	for (var i = 1; i < document.links.length; i++)
	{
		document.links[i].target = "_blank";
	}
}