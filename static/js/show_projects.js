$(document).on('change', 'input:radio[name=projects]', function(){
	 if($(this).val() == 'All'){
       $('div[id^="tech"]').show(); 
	 $('div[id^="social"]').show();
    $('div[id^="web"]').show(); 
	 $('div[id^="branding"]').show();
    }
	else if($(this).val() == 'Branding'){
    $('div[id^="tech"]').hide(); 
	 $('div[id^="social"]').hide();
    $('div[id^="web"]').hide(); 
	 $('div[id^="branding"]').show();
	}
	else if($(this).val() == 'Tech'){
    $('div[id^="tech"]').show(); 
	 $('div[id^="social"]').hide();
    $('div[id^="web"]').hide(); 
	 $('div[id^="branding"]').hide();
	}
	else if($(this).val() == 'Social'){
    $('div[id^="tech"]').hide(); 
	 $('div[id^="social"]').show();
    $('div[id^="web"]').hide(); 
	 $('div[id^="branding"]').hide();
	}
	else if($(this).val() == 'Web'){
    $('div[id^="tech"]').hide(); 
	 $('div[id^="social"]').hide();
    $('div[id^="web"]').show(); 
	 $('div[id^="branding"]').hide();
	}
});