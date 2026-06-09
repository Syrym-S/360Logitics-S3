<?php 
$prefix = "prodavay_";

if(!wp_next_scheduled("solution_test")){
    wp_schedule_event(time(),$prefix . "every_month","solution_test");
}

if(!wp_next_scheduled("em_five_minutes")){
    wp_schedule_event(time(),$prefix . "every_five_minutes","em_five_minutes");
}

if(!wp_next_scheduled($prefix . "check_products_monthly")){
    wp_schedule_event(time(),$prefix . "every_month",$prefix . "check_products_monthly");
}

if(!wp_next_scheduled($prefix . "check_products_daily")){
    wp_schedule_event(time(),$prefix . "every_week",$prefix . "check_products_daily");
}
?>