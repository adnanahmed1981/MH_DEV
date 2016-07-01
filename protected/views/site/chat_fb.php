 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <title>Comet demo</title>
 
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/prototype.js"></script>

        <style>
            @media only screen and (max-width : 340px)
            {
                .chat-sidebar
                {
                    display: none !important;
                }
               
                .chat-popup
                {
                    display: none !important;
                }
            }

            .popup-box
            {
                display: none;
                position: fixed;
                bottom: 0px;
                right: 220px;
                height: 285px;
                background-color: rgb(237, 239, 244);
                width: 300px;
                border: 1px solid rgba(29, 49, 91, .3);
            }
           
            .popup-box .popup-head
            {
                background-color: #6d84b4;
                padding: 5px;
                color: white;
                font-weight: bold;
                font-size: 14px;
                clear: both;
            }
           
            .popup-box .popup-head .popup-head-left
            {
                float: left;
            }
           
            .popup-box .popup-head .popup-head-right
            {
                float: right;
                opacity: 0.5;
            }
           
            .popup-box .popup-head .popup-head-right a
            {
                text-decoration: none;
                color: inherit;
            }
           
            .popup-box .popup-messages
            {
                height: 100%;
                overflow-y: scroll;
            }
           


        </style>
    </head>
    <body>

       
                <a href="javascript:register_popup('narayan-prusty', 'Narayan Prusty');">
                    <img width="30" height="30" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xap1/v/t1.0-1/p50x50/1510656_10203002897620130_521137935_n.jpg?oh=572eaca929315b26c58852d24bb73310&oe=54BEE7DA&__gda__=1418131725_c7fb34dd0f499751e94e77b1dd067f4c" />
                    <span>Narayan Prusty</span>
                </a>
                <a href="javascript:register_popup('qnimate', 'QNimate');">
                    <img width="30" height="30" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xap1/v/t1.0-1/p50x50/1510656_10203002897620130_521137935_n.jpg?oh=572eaca929315b26c58852d24bb73310&oe=54BEE7DA&__gda__=1418131725_c7fb34dd0f499751e94e77b1dd067f4c" />
                    <span>QNimate</span>
                </a>
                <a href="javascript:register_popup('qscutter', 'QScutter');">
                    <img width="30" height="30" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xap1/v/t1.0-1/p50x50/1510656_10203002897620130_521137935_n.jpg?oh=572eaca929315b26c58852d24bb73310&oe=54BEE7DA&__gda__=1418131725_c7fb34dd0f499751e94e77b1dd067f4c" />
                    <span>QScutter</span>
                </a>
                <a href="javascript:register_popup('qidea', 'QIdea');">
                    <img width="30" height="30" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xap1/v/t1.0-1/p50x50/1510656_10203002897620130_521137935_n.jpg?oh=572eaca929315b26c58852d24bb73310&oe=54BEE7DA&__gda__=1418131725_c7fb34dd0f499751e94e77b1dd067f4c" />
                    <span>QIdea</span>
                </a>
                <a href="javascript:register_popup('qazy', 'QAzy');">
                    <img width="30" height="30" src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xap1/v/t1.0-1/p50x50/1510656_10203002897620130_521137935_n.jpg?oh=572eaca929315b26c58852d24bb73310&oe=54BEE7DA&__gda__=1418131725_c7fb34dd0f499751e94e77b1dd067f4c" />
                    <span>QAzy</span>
                </a>
                <a href="javascript:register_popup('qblock', 'QBlock');">
                    <span>QBlock</span>
                </a>
       
  
  <div id="content">
  </div>
 
  <p>
    <form action="" method="get" onsubmit="comet.doRequest($('word').value);$('word').value='';return false;">
      <input type="text" name="word" id="word" value="" />
      <input type="submit" name="submit" value="Send" />
    </form>
  </p>
	
<div class="row" style="
    bottom: 0;
    height: 285px;
    position: fixed;
">
	<div id="qscutter" class="popup-box chat-popup"	style="right: 10px; display: block;">
		<div class="popup-head">
			<div class="popup-head-left">QScutter</div>
			<div class="popup-head-right">
				<a href="javascript:close_popup('qscutter');">X</a>
			</div>
			<div style="clear: both"></div>
		</div>
		<div class="popup-messages"></div>
	</div>

	<script type="text/javascript">
	navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;

	if (navigator.vibrate) {
		// vibration API supported
		navigator.vibrate(1000);
	}
 
	
  var Comet = Class.create();
  Comet.prototype = {
 
    timestamp: 0,
    url: 'ajaxChatBackend',
    noerror: true,
 
    initialize: function() { },
 
    connect: function()
    {
      this.ajax = new Ajax.Request(this.url, {
        method: 'get',
        parameters: { 'timestamp' : this.timestamp },
        onSuccess: function(transport) {
          // handle the server response
          var response = transport.responseText.evalJSON();
          this.comet.timestamp = response['timestamp'];
          this.comet.handleResponse(response);
          this.comet.noerror = true;
        },
        onComplete: function(transport) {
          // send a new ajax request when this request is finished
          if (!this.comet.noerror)
            // if a connection problem occurs, try to reconnect each 5 seconds
            setTimeout(function(){ comet.connect() }, 5000); 
          else
            this.comet.connect();
          this.comet.noerror = false;
        }
      });
      this.ajax.comet = this;
    },
 
    disconnect: function()
    {
    },
 
    handleResponse: function(response)
    {
      $('content').innerHTML += '<div>' + response['msg'] + '</div>';
    },
 
    doRequest: function(request)
    {
      new Ajax.Request(this.url, {
        method: 'get',
        parameters: { 'msg' : request 
      }});
    }
  }
  var comet = new Comet();
  comet.connect();

  //this function can remove a array element.
  Array.remove = function(array, from, to) {
      var rest = array.slice((to || from) + 1 || array.length);
      array.length = from < 0 ? array.length + from : from;
      return array.push.apply(array, rest);
  };

  //this variable represents the total number of popups can be displayed according to the viewport width
  var total_popups = 0;
 
  //arrays of popups ids
  var popups = [];

  //this is used to close a popup
  function close_popup(id)
  {
      for(var iii = 0; iii < popups.length; iii++)
      {
          if(id == popups[iii])
          {
              Array.remove(popups, iii);
             
              document.getElementById(id).style.display = "none";
             
              calculate_and_display_popups();
             
              return;
          }
      }  
  }

  //displays the popups. Displays based on the maximum number of popups that can be displayed on the current viewport width
  function display_popups()
  {
      var right = 10;
     
      var iii = 0;
      for(iii; iii < total_popups; iii++)
      {
          if(popups[iii] != undefined)
          {
              var element = document.getElementById(popups[iii]);
              element.style.right = right + "px";
              right = right + 320;
              element.style.display = "block";
          }
      }
     
      for(var jjj = iii; jjj < popups.length; jjj++)
      {
          var element = document.getElementById(popups[jjj]);
          element.style.display = "none";
      }
  }
 
  //creates markup for a new popup. Adds the id to popups array.
  function register_popup(id, name)
  {
     
      for(var iii = 0; iii < popups.length; iii++)
      {  
          // Already registered. Bring it to front.
          if(id == popups[iii])
          {
              // Remove from array
              Array.remove(popups, iii);
              // Add to beginning of array
              popups.unshift(id);
              calculate_and_display_popups();

              return;
          }
      }              

      // Not registered
      var element = '<div class="popup-box chat-popup" id="'+ id +'">';
      element = element + '<div class="popup-head">';
      element = element + '<div class="popup-head-left">'+ name +'</div>';
      element = element + '<div class="popup-head-right"><a href="javascript:close_popup(\''+ id +'\');">&#10005;</a></div>';
      element = element + '<div style="clear: both"></div></div><div class="popup-messages"></div></div>';
     
      document.getElementsByTagName("body")[0].innerHTML = document.getElementsByTagName("body")[0].innerHTML + element; 

      // Add to beginning of array
      popups.unshift(id);
             
      calculate_and_display_popups();
     
  }
 
  //calculate the total number of popups suitable and then populate the toatal_popups variable.
  function calculate_and_display_popups()
  {
      var width = window.innerWidth;
      if(width < 320)
      {
          total_popups = 0;
      }
      else
      {
          width = width;
          //320 is width of a single popup box
          total_popups = parseInt(width/320);
      }
     
      display_popups();
     
  }
 
  //recalculate when window is loaded and also when window is resized.
  window.addEventListener("resize", calculate_and_display_popups);
  window.addEventListener("load", calculate_and_display_popups);
 
</script>
 
  </body>
  </html>