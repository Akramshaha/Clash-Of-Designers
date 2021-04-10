<?php

$user_reg = mysqli_query($db ,"SELECT users.*, design_event_registration.*, design_event_moderator.event_id FROM users
                                INNER JOIN design_event_registration,design_event_moderator WHERE users.id = design_event_registration.user_id AND design_event_registration.event_id=design_event_moderator.event_id AND design_event_registration.response=1");
$user_all = mysqli_num_rows($user_reg);



$user_re = mysqli_query($db ,"SELECT users.*, design_event_registration.*, design_event_moderator.event_id FROM users
INNER JOIN design_event_registration,design_event_moderator WHERE users.id = design_event_registration.user_id AND design_event_registration.event_id=design_event_moderator.event_id  AND design_event_registration.response=0");
$user_co = mysqli_num_rows($user_re);



$user_de = mysqli_query($db ,"SELECT users.*, design_event_registration.*, design_event_moderator.event_id FROM users
INNER JOIN design_event_registration, design_event_moderator WHERE users.id = design_event_registration.user_id AND design_event_registration.event_id=design_event_moderator.event_id AND design_event_registration.response=-1");
$user_decline = mysqli_num_rows($user_de);

?>