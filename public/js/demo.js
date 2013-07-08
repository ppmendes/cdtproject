$(document).ready(function(){
	
	
	
	// third example
	$("#red").treeview({
		animated: "fast",
		collapsed: true,
		unique: true,
		persist: "cookie",
		toggle: function() {
			window.console && console.log("%o was toggled", this);
		}
	});
        
        
        $(".numeric").numeric();
        $(".integer").numeric(false);
        $(".positive").numeric({negative: false});
        $(".positive-integer").numeric({decimal: false, negative: false});

        $("." +
            "mask_processoadministrativo").mask('99999.999999/9999-99');
	

});