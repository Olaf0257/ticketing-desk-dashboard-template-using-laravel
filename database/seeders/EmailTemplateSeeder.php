<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Helpers\Uuid;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_templates')->insert([
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'mail_ticket_opened',
                'subject' => 'Hello',
                'message' => '<p>Hello {$user_name},</p><p>A ticket is opened and the ticket id is #{$ticket_id}.</p><p><span style="font-weight: bolder; color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="font-family: &quot;Times New Roman&quot;;">Thank You</span></span></p><p><br></p>',
                'status' => true,
                'language_id' => 1,
                'system_template' => true,
                'merge_fields' => '{$ticket_id}, {$user_name}, {$app_url}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'ticket_opened',
                'subject' => 'Hello',
                'message' => '<p>Hello {$user_name},<br><br>A ticket is opened and ticket id is #:{$ticket_id}.<br>Subject: {$subject}<br>Department: {$department}<br>Please click the {$ticket_url} to view the ticket.</p><p><span style="font-weight: bolder; color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="font-family: &quot;Times New Roman&quot;;">Thank You<br></span></span></p>',
                'status' => true,
                'language_id' => 1,
                'system_template' => true,
                'merge_fields' => '{$ticket_id}, {$user_name}, {$app_url}, {$subject}, {$department}, {$ticket_url}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'ticket_reply',
                'subject' => 'Hello',
                'message' => '<div class="gs" style="margin: 0px; padding: 0px 0px 20px; width: 1063.2px;"><div class="" style=""><div id=":pa" class="ii gt" style="direction: ltr; margin: 8px 0px 0px; padding: 0px; position: relative;"><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif">Hello {$user_name},<br><br>A ticket reply is added for your ticket #:{$ticket_id}.<br>To see the details check {$ticket_url}</font></font></font></div><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif"><br></font></font></font><b style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="font-family: &quot;Times New Roman&quot;;">Thank you</span></b><div class="yj6qo" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div><div class="adL" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div></div><div style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: 0.875rem;"><b><span style="font-family: &quot;Times New Roman&quot;;"><br></span></b></div></div><div class="hi" style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: medium; border-bottom-left-radius: 1px; border-bottom-right-radius: 1px; padding: 0px; width: auto; background: rgb(242, 242, 242); margin: 0px;"></div></div></div>',
                'status' => true,
                'language_id' => 1,
                'system_template' => true,
                'merge_fields' => '{$ticket_id}, {$user_name}, {$app_url}, {$subject}, {$department}, {$ticket_url}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'ticket_opened_department',
                'subject' => 'Hello',
                'message' => '<div class="gs" style="margin: 0px; padding: 0px 0px 20px; width: 1063.2px;"><div class="" style=""><div id=":pa" class="ii gt" style="direction: ltr; margin: 8px 0px 0px; padding: 0px; position: relative;"><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif">Hello {$user_name},<br><br>A ticket is opened to your department {$department}.<br>Ticket id: #{$ticket_id}.<br>Subject: {$subject}.</font></font></font></div><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><br><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif">To view the ticket, please click {$ticket_url}.</font></font></font></font></font></font></div><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif"><br></font></font></font></font></font></font><b style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="font-family: &quot;Times New Roman&quot;;">Thank you</span></b><div class="yj6qo" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div><div class="adL" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div></div><div style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: 0.875rem;"><b><span style="font-family: &quot;Times New Roman&quot;;"><br></span></b></div></div><div class="hi" style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: medium; border-bottom-left-radius: 1px; border-bottom-right-radius: 1px; padding: 0px; width: auto; background: rgb(242, 242, 242); margin: 0px;"></div></div></div>',
                'status' => true,
                'language_id' => 1,
                'system_template' => true,
                'merge_fields' => '{$ticket_id}, {$user_name}, {$app_url}, {$department}, {$subject}, {$ticket_url}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'ticket_assigned',
                'subject' => 'Hello',
                'message' => '<div class="gs" style="margin: 0px; padding: 0px 0px 20px; width: 1063.2px;"><div class="" style=""><div id=":pa" class="ii gt" style="direction: ltr; margin: 8px 0px 0px; padding: 0px; position: relative;"><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif">Hello {$user_name},<br><br>A Ticket is assigned for you.<br>Ticket id: #:{$ticket_id}<br>Ticket Subject: {$subject}<br><br>Please click the link {$ticket_url} to view it.</font></font></font></div><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif"><br></font></font></font><b style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="font-family: &quot;Times New Roman&quot;;">Thank you</span></b><div class="yj6qo" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div><div class="adL" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div></div><div style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: 0.875rem;"><b><span style="font-family: &quot;Times New Roman&quot;;"><br></span></b></div></div><div class="hi" style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: medium; border-bottom-left-radius: 1px; border-bottom-right-radius: 1px; padding: 0px; width: auto; background: rgb(242, 242, 242); margin: 0px;"></div></div></div>',
                'status' => true,
                'language_id' => 1,
                'system_template' => true,
                'merge_fields' => '{$ticket_id}, {$user_name}, {$app_url}, {$subject}, {$department}, {$ticket_url}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'assigned_to_reply_mail',
                'subject' => 'Hello',
                'message' => '<div class="gs" style="margin: 0px; padding: 0px 0px 20px; width: 1063.2px;"><div class="" style=""><div id=":pa" class="ii gt" style="direction: ltr; margin: 8px 0px 0px; padding: 0px; position: relative;"><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif">Hello {$user_name},<br><br>A reply is added to the ticket with id #{$ticket_id} that assigned for you.<br>Subject: {$subject}<br>Department: {$department}<br><br>To view the reply, please click {$ticket_url}.</font></font></font></div><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif"><br></font></font></font><b style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="font-family: &quot;Times New Roman&quot;;">Thank you</span></b><div class="yj6qo" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div><div class="adL" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div></div><div style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: 0.875rem;"><b><span style="font-family: &quot;Times New Roman&quot;;"><br></span></b></div></div><div class="hi" style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: medium; border-bottom-left-radius: 1px; border-bottom-right-radius: 1px; padding: 0px; width: auto; background: rgb(242, 242, 242); margin: 0px;"></div></div></div>',
                'status' => true,
                'language_id' => 1,
                'system_template' => true,
                'merge_fields' => '{$ticket_id}, {$user_name}, {$app_url}, {$subject}, {$department}, {$ticket_url}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'department_staff_reply_mail',
                'subject' => 'Hello',
                'message' => '<div class="gs" style="margin: 0px; padding: 0px 0px 20px; width: 1063.2px;"><div class="" style=""><div id=":pa" class="ii gt" style="direction: ltr; margin: 8px 0px 0px; padding: 0px; position: relative;"><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif">Hello {$user_name},<br><br>{$staff_name} from the department {$department} added a reply for the the ticket #:{$ticket_id} ({$subject}).<br>To view the reply, please click {$ticket_url}</font></font></font></div><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif"><br></font></font></font><b style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="font-family: &quot;Times New Roman&quot;;">Thank you</span></b><div class="yj6qo" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div><div class="adL" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div></div><div style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: 0.875rem;"><b><span style="font-family: &quot;Times New Roman&quot;;"><br></span></b></div></div><div class="hi" style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: medium; border-bottom-left-radius: 1px; border-bottom-right-radius: 1px; padding: 0px; width: auto; background: rgb(242, 242, 242); margin: 0px;"></div></div></div>',
                'status' => true,
                'language_id' => 1,
                'system_template' => true,
                'merge_fields' => '{$ticket_id}, {$user_name}, {$app_url}, {$subject}, {$department}, {$ticket_url}, {$staff_name}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'department_user_reply_mail',
                'subject' => 'Hello',
                'message' => '<div class="gs" style="margin: 0px; padding: 0px 0px 20px; width: 1063.2px;"><div class="" style=""><div id=":pa" class="ii gt" style="direction: ltr; margin: 8px 0px 0px; padding: 0px; position: relative;"><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif">Hello {$user_name},<br><br>User replied for the ticket with ticket id: #{$ticket_id}.<br>Subject: {$subject}<br>Department: {$department}<br><br>To view the ticket, please click {$ticket_url}</font></font></font></div><div id=":p9" class="a3s aiL " style="overflow: hidden; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: 1.5;"><font color="#222222"><font size="2"><font face="Arial, Helvetica, sans-serif"><br></font></font></font><b style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="font-family: &quot;Times New Roman&quot;;">Thank you</span></b><div class="yj6qo" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div><div class="adL" style="color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: small;"></div></div><div style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: 0.875rem;"><b><span style="font-family: &quot;Times New Roman&quot;;"><br></span></b></div></div><div class="hi" style="color: rgb(34, 34, 34); font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif; font-size: medium; border-bottom-left-radius: 1px; border-bottom-right-radius: 1px; padding: 0px; width: auto; background: rgb(242, 242, 242); margin: 0px;"></div></div></div>',
                'status' => true,
                'language_id' => 1,
                'system_template' => true,
                'merge_fields' => '{$ticket_id}, {$user_name}, {$app_url}, {$subject}, {$department}, {$ticket_url}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
