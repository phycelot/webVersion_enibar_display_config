function getPageInfo(pageName){
  console.log("page :"+pageName);
  app_id='1885210111766331';
  secret='260e1a98364e4642cc8bb7d389578073';
  token=app_id+'|'+secret;
  API1='https://graph.facebook.com/'+pageName+'?fields=fan_count,talking_about_count,name&access_token='+ token;
  $.getJSON(API1, function(page) {
    console.log(page);
    pageID=page.id;
    APIpost=("https://graph.facebook.com/v2.6/"+pageID+"/posts?access_token="+token);
    APIevent=("https://graph.facebook.com/v2.6/"+pageID+"/events?access_token="+token); 
    console.log(APIpost);
    console.log(APIevent);
    $.getJSON(APIpost, function(post) {
    console.log(post);
    });
    $.getJSON(APIevent, function(event) {
    console.log(event);
    });
    });
  }
  // getPageInfo('Enib.bar');
  // getPageInfo('bde.enib');