$(function() {
	$('.menu .menuitem').hover(onHover, onLeave);
	$('.menu .menuitem').click(onClick);
});

function onHover(e) {
	if (!$(e.target).hasClass('selected')) {
		$('.hover').removeClass('hover');
		$(e.target).addClass('hover');
	}
}

function onLeave(e) {
	$('.hover').removeClass('hover');
}

function onClick(e) {
	$(window).css('cursor', 'progress');
	$('.hover').removeClass('hover');
	window.location = $(e.target).attr('path');
	return false;
}

function logged_in() {
	var sessionCookie = getCookie('PHPSESSID');
	if (sessionCookie && sessionCookie !== '') {
		return true;
	}
	var persistentSession = getCookie('sasac_forum_auth');
	if (persistentSession && persistentSession !== '') {
		return true;
	}
	return false;
}

function getCookie(name) {
	var cookiename = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(cookiename) == 0) return c.substring(cookiename.length,c.length);
	}
	return null;
}

function setCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getSessionCookie(name) {
	var search = name + "=";
	var returnvalue = "";
	if (document.cookie.length > 0) {
		var offset = document.cookie.indexOf(search);
		// if cookie exists
		if (offset != -1) { 
			offset += search.length;
			// set index of beginning of value
			end = document.cookie.indexOf(";", offset);
			// set index of end of cookie value
			if (end == -1) end = document.cookie.length;
			returnvalue=unescape(document.cookie.substring(offset, end));
		}
	}
	return returnvalue;
}