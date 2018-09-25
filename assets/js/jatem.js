$.ajax({
    type: "GET",
    url: "_proses/user_proses.php?action=jatemlist",
    success: function(response){                    
        $("#jatem").html(response); 
    }
});