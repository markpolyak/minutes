function sender(funcSuc, funcErr, params)
{
	$.ajax({
		type: 'POST',
		url: "handler.php",
		data: $.param( params ),
		cache: false,
		success: function(response)
		{
			php_err = response;

			try
			{
				funcSuc(response);
			}
			catch (e)
			{
				console.log("JS:\n" + response + "\n\nPHP:\n" + php_err);
			}
			
		},
		error: function()
		{
			funcErr();
		}
	});
}