<!DOCTYPE html>
<html>
<head>
</head>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
  API = 'https://enib.net/enibar/note';
	$.getJSON(API, function(note) {
    console.log(note);
	});
</script>