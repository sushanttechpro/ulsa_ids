<!-- <section class="content"> -->
<script src="<?php echo $base_url; ?>assets/js/jquery.min.js"></script>

<section class="content page-calendar">

    <script>
    $(document).ready(function(){
        var doctor_id=$('#doctor_id').val();
        // alert(doctor_id);
        
        var calendar = $('#calendar').fullCalendar({
        
            editable:true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay',
            },
         
            events:"<?php echo base_url(); ?>doctors/fetch",
            selectable:true,
            selectHelper:true,
            select:function(start, end, allDay)
            {
                // var title = prompt("Enter Event Title");
                // if(title)
                // {
                //     var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                //     var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                //     var doctor_id=$('#doctor_id').val();
                //     $.ajax({
                //         url:"<?php echo base_url(); ?>doctors/insert",
                //         type:"POST",
                //         data:{title:title, start:start, end:end,doctor_id:doctor_id},
                //         success:function()
                //         {
                //             calendar.fullCalendar('refetchEvents');
                //             alert("Added Successfully");
                //         }
                //     })
                // }
            },
            editable:true,
            eventResize:function(event)
            {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");

                var title = event.title;

                var id = event.id;

                $.ajax({
                    url:"<?php echo base_url(); ?>doctors/update",
                    type:"POST",
                    data:{title:title, start:start, end:end, id:id},
                    success:function()
                    {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Update");
                    }
                })
            },
            eventDrop:function(event)
            {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                //alert(start);
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                //alert(end);
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url:"<?php echo base_url(); ?>doctors/update",
                    type:"POST",
                    data:{title:title, start:start, end:end, id:id},
                    success:function()
                    {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Updated");
                    }
                })
            },
            // eventClick:function(event)
            // {
            //     if(confirm("Are you sure you want to remove it?"))
            //     {
            //         var id = event.id;
            //         $.ajax({
            //             url:"<?php echo base_url(); ?>doctors/delete",
            //             type:"POST",
            //             data:{id:id},
            //             success:function()
            //             {
            //                 calendar.fullCalendar('refetchEvents');
            //                 alert('Event Removed');
            //             }
            //         })
            //     }
            // }
        });
    });
             
    </script> 

       
        <div class="container">
            <div id="calendar"></div>

            <input type="hidden" name="doctor_id" id="doctor_id" value="<?php echo $id; ?>">
        </div>
 

</section>
<div class="color-bg"></div>