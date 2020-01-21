/*
Author by: Mark Taylor
Created: 27/09/2013
Last updated: 27/09/2013

Revision history: 
27/09/2013 - Initial creation.

Description: Sets the background colour of the 'Portal' logo at the top of the page to red when 'debug' mode is set on.
*/

$(function(){
	$(".portal").addClass("portaldebug");
	console.log("Error reporting now turned on.");
})