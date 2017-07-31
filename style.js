$(document).ready(function()
{
	$(".close-chat").click(function()
	{
		$('.msg_box').hide();
	});	
	
	$(".user-chat-open").click(function()
	{
		$('.msg_wrap').show();
		$('.msg_box').show();
	});
});