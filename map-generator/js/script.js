// jQuery(document).ready(function(){
	// console.log(jQuery().jquery); // This prints v1.4.2
   // // console.log($j().jquery); // This prints v1.9.1
// });
jQuery(document).ready(function(){
	jQuery('#geocomplete').geocomplete({  details: 'form' })
	.bind('geocode:result', function(event, result){
		console.log('Result: ' + result.formatted_address);
	})
	.bind('geocode:error', function(event, status){
		console.log('ERROR: ' + status);
	})
	.bind('geocode:multiple', function(event, results){
		console.log('Multiple: ' + results.length + ' results found');
	});
	
	jQuery(".swatch-anchor").on('click', function(event){
		event.stopPropagation();
		event.stopImmediatePropagation();
		var kids = jQuery( event.target ).children();
		kids.prevObject.parent().trigger("click");
		imgsrc = kids.prevObject[0].currentSrc;
		if(imgsrc)
		{
			myString = imgsrc.replace('-32x32','');
			// console.log(myString);
			jQuery('#img_frame').attr('src',myString);
		}
		else
		{	//color
			console.log(kids.context.style.backgroundColor);
			// alert('asda');
			txt = kids.context.style.backgroundColor;
			jQuery(".footer-starts").css({"color":txt});
			jQuery(".header-starts").css({"color":txt});
			
			// jQuery('.footer-starts').toggleClass('black_text');        
			// jQuery('.header-starts').toggleClass('black_text');    
		}
	}); 
	
	// jQuery('#starmap-datepicker').datetimepicker({
		// format: 'L',
		// defaultDate: new Date()
	// });
	jQuery('#starmap-timepicker').datetimepicker({
		format: 'LT',
		defaultDate: new Date()
	});
	
	jQuery("#generate").on('click', function(event){
		event.stopPropagation();
		event.stopImmediatePropagation();
		 
		directory = jQuery("#generate").attr('data-dir');
		 
		datepicker = jQuery('#starmap-datepicker').val();
		timepicker = jQuery('#starmap-timepicker').val();
		date = new Date(datepicker + " " + timepicker ) ;
		console.log(datepicker + " " + timepicker);
		jsonarray = {
			"id":"preview",
			"dir" : directory,
			"mouse":false,
			"projection" :'polar',
			"width":350,
			"height":350,
			"gradient":true,
			"showgalaxy":false,
			"constellations":true,
			"constellationlabels":true,
			"constellationboundaries":false,
			"showdate":false,
			"showposition":false,
			"showstars":true,
			"meteorshowers":false,
			"showstarlabels":false,
			"negative":false,
			"transparent":true,
			/*"background":"#ffffff",*/
			"color":"#000000",
			"credit": false,
			"showplanets": false,
			"showplanetlabels": false,
			fontsize:"10px",
			fontfamily :"verdana",
			longitude: jQuery("#lng").val(),
			latitude: jQuery("#lat").val(),
			clock: date 
		};			
		planetarium = $.virtualsky(jsonarray);
		planetarium.draw(); 
		
		// // jQuery('#hidden-date').val(datepicker);
		
		jQuery('#hidden-time').val(timepicker);
		
		jQuery('#hidden-location').val(jQuery("#geocomplete").val());
		jQuery('#hidden-latitude').val(jQuery("#lat").val());
		jQuery('#hidden-longitude').val(jQuery("#lng").val());
		
		jQuery('#hidden-message1').val(jQuery("#title_star").val());
		jQuery('#hidden-message2').val(jQuery("#footer_star").val());
		
		title_star = jQuery('#title_star').val();
		jQuery( "#show_title" ).html(title_star);
	 
		title_star = jQuery('#footer_star').val();
		jQuery( "#footer_text" ).html(title_star);
		
		date = jQuery('#starmap-datepicker').val();
		var d = new Date(date);
		year =  d.toLocaleString('default', { year: 'numeric' }); 
		monthname =  d.toLocaleString('default', { month: 'long' }); 
		day =  d.toLocaleString('default', { day: '2-digit' }); 
	 
		time = jQuery('#starmap-timepicker').val();
		locationa = jQuery('#geocomplete').val();
		lat = jQuery('#lat').val();
		lng = jQuery('#lng').val();
		
		lat = Number(jQuery("#lat").val()).toFixed(1);
		lng = Number(jQuery("#lng").val()).toFixed(1);

		jQuery('#footer_third').html('STAR OVER </br> '+locationa+' | '+lat +'N , '+lng +'E');
		jQuery('#footer_forth').html('ON, '+day+'-'+ monthname+ '-'+year+' at '+time+''); 
	}); 
});