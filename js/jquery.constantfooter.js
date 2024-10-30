(function($)
{
	// This script was written by Steve Fenton
	// http://www.stevefenton.co.uk/Content/Jquery-Constant-Footer/
	// Feel free to use this jQuery Plugin
	
	var nextSetIdentifier = 0;
	var classModifier = "";
	
	var feedItems;
	var feedIndex;
	var feedDelay = 10;
	
	function CycleFeedList(feedList, index) {
		feedItems = feedList;
		feedIndex = index;
		ShowNextFeedItem();
	}
	
	function ShowNextFeedItem() {
		//put that feed content on the screen!
		$("." + classModifier).children().fadeOut(1000, function () {
			$("." + classModifier).html(feedItems[feedIndex]);
			PadDocument();
			feedIndex++;
			if (feedIndex >= feedItems.length) {
				feedIndex = 0;
			}
			window.setTimeout(ShowNextFeedItem, (feedDelay * 1000));
		});
	}

	function StripCdataEnclosure(string) {
		if (string.indexOf("<![CDATA[") > -1) {
			string = string.replace("<![CDATA[", "").replace("]]>", "");
		}
		return string;
	}
	
	function PadDocument() { 
		var paddingRequired = $("." + classModifier).height();
		$("#" + classModifier + "padding").css({ paddingTop: paddingRequired+"px"});
	}
	
	jQuery.fn.constantfooter = function (settings) { //alert(settings)
	
		//var config = { "classModifier": "constantfooter", "feed": "", "feedlink": "Read more &raquo;", "opacity": "0.8" };
		var config = { "classModifier": "constantfooter", "feed": "", "feedlink": "Read more &raquo;", "opacity": "" };
		
		if (settings) {
			$.extend(config, settings);
		}

		return this.each(function () {
			
			classModifier = config.classModifier;

			// Add a div used for body padding
			$(this).before("<div id=\"" + config.classModifier + "padding\">&nbsp;</div>");
			
			// Hide it
			$(this).hide().addClass(classModifier).css({ position: "fixed", bottom: "0px", left: "0px", width: "100%", color: "#FFFFFF", margin: "0", textAlign: "center", backgroundColor: "#000000", height: "100px", zIndex: "1000" });

			// Show it
			$(this).fadeTo(1000, config.opacity);
			
			PadDocument();
			
			// Process any feeds
			if (config.feed.length > 0) {
		
				var feedList = new Array();
				
				$.get(config.feed, function(xmlDoc) {
					
					var itemList = xmlDoc.getElementsByTagName("item");
					
					for (var i = 1; i <= itemList.length; i++) {
					
						var title = xmlDoc.getElementsByTagName("title")[i].childNodes[0].nodeValue;
						var link = xmlDoc.getElementsByTagName("link")[i].childNodes[0].nodeValue;
						var description = xmlDoc.getElementsByTagName("description")[i].childNodes[0].nodeValue;
					
						var article = "<div class=\"item\">";
						
						if (link != null) {
							article += "<a href=\"" + link + "\">";
						}
						article += "<h2>" + title + "</h2>";
						if (link != null) {
							article += "</a>";
						}
						
						article += "<div class=\"description\"><p>" + description + "</p></div>";
						
						if (link != null) {
							article += "<div class=\"link\"><a href=\"" + link + "\">" + config.feedlink + "</a></div>";
						}
						
						article += "</div>";
			 
						feedList[feedList.length] = article;
					}
					
					if (feedList.length > 0) {
						CycleFeedList(feedList, 0);
					}
				});

			}
		});
	};
})(jQuery);
			
