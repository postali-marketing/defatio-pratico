function request (controller, method, callback, data)
{
	xhr = new XMLHttpRequest;
	xhr.open('POST', 'request/'+controller+'/'+method, true);

	if(typeof(data == "object"))
	{
		data = JSON.stringify(data);
		xhr.setRequestHeader("Content-type", "text/json");
	}
	xhr.onload=function(){
		var response = this.responseText;
		try{response = JSON.parse(response); }catch(e){ return console.error(e); }
		if(callback) callback(response,xhr);
	}
	xhr.send(data);
	return xhr;
}