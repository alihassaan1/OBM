<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

var currentLocationStr = location.href;
var currentLocation = window.location;
var urlLength = currentLocationStr.length
var urlFirstPart = currentLocationStr.substring(0,44);
	
var interval = setInterval(function(){ 	
	if(urlFirstPart === 'https://optimizedbodyandmind.co.uk/checkout/' && !(urlLength < 44) && urlLength> 85){
		var firstPart = currentLocationStr.substring(currentLocationStr.indexOf('?') + 1);
		var completePath = "?" + firstPart + "&api=True";
		

		if(firstPart.includes('&')){
			clearInterval(interval);
			return;
		}
		
		window.location = completePath;
		clearInterval(interval);
        return;
	}
}, 3000);

</script>