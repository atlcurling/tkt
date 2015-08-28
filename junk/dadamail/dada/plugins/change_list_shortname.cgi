#!/usr/bin/perl -w
package change_list_shortname;
use strict;

# make sure the DADA lib is in the lib paths!
use lib qw(../ ../DADA/perllib);

# use some of those Modules
use DADA::Config 5.0.0;
use DADA::Template::HTML;
use DADA::App::Guts;
use DADA::MailingList::Settings;

# we need this for cookies things
use CGI;
my $q = new CGI;
$q->charset($DADA::Config::HTML_CHARSET);
$q = decode_cgi_obj($q);

use CGI::Carp qw(fatalsToBrowser set_message);
    BEGIN {
       sub handle_errors {
		my $TIME = scalar(localtime());
        print qq{
		<html>
		<head></head>
		<body>
		<div style="padding:5px;border:3px dotted #ccc; font-family:helvetica; font-size:.7em; line-height:150%; width:600px;margin-left:auto;margin-right:auto;margin-top:100px;">
		<img alt="Dada Mail" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAAC
		WCAMAAAAL34HQAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAAxQTFRFCAgIXV
		1dp6en/f39XG2aJgAAAqpJREFUeNrs3OGO4yAMBOB0+/7vvFWRLMtjjAkEqDT5dddyy1fJNwSH7vU+8
		rrIWsX6+15k/TTr+l6v12s6jqxlrA/oUtdEHFm7WKXOyPotltZ8CmuijKw1LCks7ZiVFGQtYOlocF8n
		63CWZAGWkbxF1uGsYGEW1mBGkPUoyw13fJesY1k6GuKyWxoQZM0I9ya6t9TIeojV3KPWsqNwydrOisP
		duKWSPn+4l/tkTWc1w702Rm+QyNrIaoZ7HB/3GkxkzWVl2rW1lgRZJ7Ay4a6Lzx1G1kZWJtx18XVth8
		oqrh+R6iffZE1hJcM9sxgj64KrTCf1R9YUVibcm9Ggb5qFheMxhsgaZwVLr2tyh5UBWiYv4mcoY8iax
		cr8nzcmd5ihaGLtB5I1yJK1sxkNGZOulQyrfAyyBll4jieYT48pk5lTlfqD6c0PWY+ycNZaN0EPKOML
		SGK9ycIP3MgtsjpTHnG1w3baoUsK+w7mmNeEOwiyOnc+meDQ9WFYZhssAl2R2Xt5snpYZv02/YKgIkv
		cByxcKrDmyJrIynTtyw/VT8Jilukc+TfcZC1hmfN2+q8Bq3yAaU9fyRpjmcR3tzqi1JVH1mks3KCaZq
		IkSNfXSMhaw9IpgEeZcQdF1oGs2taldivcdQaIrC2sN3yfGXdK+W/JkrWLFfeG+pYQss5gjVxk3WaZj
		oNOcPf15ADsYtQmImucVfvVAKYb2OwbmplqveDgOTdZt1lB8z1o6WLX3sxE1kaWbqPXWLX2vXvjRdbT
		LHcCt27co1c4mKz1rGAC8wr+Agi3EN1FAlmNpZqsuyw32bEa8EGXW4LN2sKnLGTdY8Xh7tbN1bqSrOh
		ZNVlpFpYOHkw3LPNPZBuD05C1niXvmeM4Zkwt94NmrjnpRdZcFvtbv8z6F2AA/5G8jEIpBJoAAAAASU
		VORK5CYII=" style="float:left;padding:10px"/></p>
		<h1>Yikes! App/Server Problem!</h1>
		<p>We apologize, but the server encountered a problem when attempting to complete its task.</p> 
		<p>More information about this error may be available in the <em>program's own error log</em>.</p> 
		<p><a href="$ENV{SERVER_ADMIN}">Contact the Server Admin</a></p>
		<p>Time of error: <strong>$TIME</strong></p> 	
		</div>
		</body> 
		</html> 
		};
	}
	set_message(\&handle_errors);
}


use Carp qw(croak carp); 


use Fcntl qw(
	LOCK_SH
	O_RDONLY
	O_CREAT
	LOCK_EX
);


my $admin_list; 
my $root_login; 
my $list; 
my $ls; 

my $Plugin_Config                = {}; 
   $Plugin_Config->{Plugin_Name} = 'Change List Shortname'; 
   $Plugin_Config->{Plugin_URL}  = $q->url; 


&init_vars; 

sub init_vars {

# DEV: This NEEDS to be in its own module - perhaps DADA::App::PluginHelper or something?

    while ( my $key = each %$Plugin_Config ) {

        if ( exists( $DADA::Config::PLUGIN_CONFIGS->{change_list_shortname}->{$key} ) ) {

            if ( defined( $DADA::Config::PLUGIN_CONFIGS->{change_list_shortname}->{$key} ) ) {

                $Plugin_Config->{$key} =
                  $DADA::Config::PLUGIN_CONFIGS->{change_list_shortname}->{$key};

            }
        }
    }
}

run()
  unless caller();

sub _init { 
	( $admin_list, $root_login ) = check_list_security(
        -cgi_obj  => $q,
        -Function => 'change_list_shortname'
    );

	$list = $admin_list;
}

sub run {

	_init(); 

	my $flavor = $q->param('flavor') || 'cgi_default';
	$ls = DADA::MailingList::Settings->new({-list => $list}); 	

	my %Mode = (
		'cgi_default'                  => \&cgi_default,
		'verify_change_list_shortname' => \&verify_change_list_shortname, 
		'change_list_shortname'        => \&change_list_shortname, 

	);

	if ( exists( $Mode{$flavor} ) ) {
		$Mode{$flavor}->();    #call the correct subroutine
	}
	else {
		&cgi_default;
	}
}


sub test_sub { 
	return 'Hello, World!'; 
}



sub cgi_default_tmpl {

return q{ 
	
	<!-- tmpl_set name="load_modalbox" value="1" -->
	<!-- tmpl_set name="title" value="Plugins &#187; Change List Shortname" -->
	<div id="screentitle"> 
		<div id="screentitlepadding">
			<!-- tmpl_var title --> 
		</div>
		<!-- tmpl_include help_link_widget.tmpl -->
	</div>
	
	
	<fieldset> 
	
	
    <form action="<!-- tmpl_var Plugin_URL -->" method="post" id="change_name_form" name="change_name_form" onSubmit="Modalbox.show('<!-- tmpl_var Plugin_URL -->', {title: 'Confirm List Shortname Change...', width: 640, height:480, params: Form.serialize('change_name_form')}); return false;" value="Verify your List Short Name Change...">
		<input type="hidden" name="flavor" id="flavor" value="verify_change_list_shortname" />
		<p><label for="new_name">Your New List Short Name:</label><input type="text" name="new_name" id="new_name" value="" maxlength="16" /></p>
		<div class="buttonfloat">
		<input type="button" onclick="Modalbox.show('<!-- tmpl_var Plugin_URL -->', {title: 'Confirm List Shortname Change...', width: 640, height:480, params: Form.serialize('change_name_form')}); return false;" value="Verify Your List Short Name Change..." class="alertive" /> 
		</div> 
		<div class="floatclear"></div>
	</form>

	</fieldset> 

};

}

sub cgi_default { 
	
	if($DADA::Config::SUBSCRIBER_DB_TYPE !~ /SQL/i){ 
		sql_backend_only_message(); 
		return; 
	}
	
	
	my $data = cgi_default_tmpl(); 
    require DADA::Template::Widgets;
	require DADA::MailingList::Settings; 
	
     my $scrn = DADA::Template::Widgets::wrap_screen(
         {
             -data           => \$data,
             -with           => 'admin',
			 -expr           => 1, 
             -wrapper_params => {
                 -Root_Login => $root_login,
                 -List       => $list,
             },
             -vars => {
				Plugin_URL => $Plugin_Config->{Plugin_URL}, 
			},
			-list_settings_vars_param => { 
				-list                 => $list,
				-dot_it               => 1,
			},

         }
     );
     e_print($scrn);
}

sub sql_backend_only_message { 
	my $tmpl = q{ 
		<!-- tmpl_set name="title" value="Plugins &#187; Change List Shortname" --> 
		<div id="screentitle"> 
			<div id="screentitlepadding">
				<!-- tmpl_var title --> 
			</div>
			<!-- tmpl_include help_link_widget.tmpl -->
		</div>
		
		<h1>Sorry,</h1>
		<p>This plugin will only work, if you have installed and configured Dada Mail to use one of the SQL backends.</p>
	};
	
    require DADA::Template::Widgets;
    my $scrn = DADA::Template::Widgets::wrap_screen(
        {
            -data           => \$tmpl,
            -with           => 'admin',
            -wrapper_params => {
                -Root_Login => $root_login,
                -List       => $ls->param('list'),
            },, 
            -vars => {
            },

            -list_settings_vars_param => {
                -list   => $list,
                -dot_it => 1,
            },
        }
    );	
	e_print($scrn);
}






sub verify_change_list_shortname_tmpl { 
	

return q{ 
	
		<!-- tmpl_if errors --> 
	
		<h1>Problems!</h1>
		
		<p>Some problems were found with the new List Short Name you picked out:</p> 
		
		<div class="badweatherbox">
		
		<ul>
			
	
		<!-- tmpl_if flags_list_exists -->

			 <li><p>
			   This list Short Name already exists. Please choose a different Short Name.
			 </p></li>

		<!-- /tmpl_if -->

		<!-- tmpl_if flags_list -->
			 <li><p>
			   Please fill out a Short Name.
			 </p></li>

		<!-- /tmpl_if -->

		<!-- tmpl_if flags_shortname_too_long -->

			 <li><p>
			   Your list Short Name is longer than 16 characters.
			 </p></li>

		<!-- /tmpl_if -->

		<!-- tmpl_if flags_slashes_in_name -->

			 <li><p>
			   Your list Short Name cannot have slashes (&quot;/&quot; or &quot;\&quot;) in the name itself.
			 </p></li>

		<!-- /tmpl_if -->

		<!-- tmpl_if flags_weird_characters -->

			 <li><p>
			   Your list Short Name appears to have weird characters in the 
			   name that may create problems. Please use only lowercase 
			   alphanumeric characters (e.g.: abc123).
			 </p></li>

		<!-- /tmpl_if -->

		<!-- tmpl_if flags_quotes -->
			 <li><p>
			   Your list Short Name cannot contain quotes.
			 </p></li>

		<!-- /tmpl_if -->
		
		</div> 
		
	<!-- tmpl_else --> 
		<fieldset> 
		<legend>Verification Successul</legend>
		<p>Your new List Short Name checks out.</p> 
		
		
		<p><strong>Please make a backup of your current Dada Mail database, before continuing.</strong></p> 
		
		<form action="<!-- tmpl_var Plugin_URL -->"  method="post" >
			<input type="hidden" name="flavor" id="flavor" value="change_list_shortname" />
			<input type="hidden" name="new_name" id="new_name" value="<!-- tmpl_var new_name -->" /> 
			<div class="buttonfloat">
			<input type="submit" value="Change your list short name from, &quot;<!-- tmpl_var list_settings.list -->&quot; to, &quot;<!-- tmpl_var new_name -->&quot;" class="processing" /> 
			</div> 
			<div class="floatclear"></div>
			
		</form>
		</fieldset> 
		
	<!-- /tmpl_if --> 

};
	
}

sub verify_change_list_shortname {
    my $new_name = strip( xss_filter( $q->param('new_name') ) );
    my ( $errors, $flags ) = check_list_setup(
        -fields => {
            list             => $new_name,
        },
    );
	# reset this, as we don't care about all the errors, but: 

	$errors = 0;
	my $change_list_name_errors = {};
#	use Data::Dumper; 
#	die Dumper($flags); 
	
	for(qw(
		list
		list_exists
		shortname_too_long
		slashes_in_name
		weird_characters
		quotes
	)){ 
		if($flags->{$_} == 1){ 
			$change_list_name_errors->{'flags_' . $_} = 1;
			$errors++; 
			
		}
	}
	
	
	my $data = verify_change_list_shortname_tmpl(); 
    require DADA::Template::Widgets;
	
     my $scrn = DADA::Template::Widgets::screen(
         {
             -data           => \$data,
  			 -expr           => 1, 
             -vars => {
				Plugin_URL => $q->url, 
				errors     => $errors, 
				new_name   => $new_name, 
				%{$change_list_name_errors}, 

			},
			-list_settings_vars_param => { 
				-list                 => $list,
				-dot_it               => 1,
			},

         }
     );
	print $q->header(); 
     e_print($scrn);
}



sub change_list_shortname { 

my $new_name = strip(xss_filter($q->param('new_name'))); 
my %p = %DADA::Config::SQL_PARAMS; 


#subscriber_table                  
#profile_table         				# no update needed.            
#profile_fields_table 	          	# no update needed.
#profile_fields_attributes_table    # no update needed.
#archives_table                    
#settings_table                    
#session_table                     # no update needed.
#bounce_scores_table               
#clickthrough_urls_table           # no update needed.
#clickthrough_url_log_table        
#mass_mailing_event_log_table      
#password_protect_directories_table


my $query_string = 
"UPDATE  $p{subscriber_table} SET list = ? WHERE list = ?;
UPDATE  $p{archives_table} SET list = ? WHERE list = ?; 	
UPDATE  $p{settings_table} SET list = ? WHERE list = ?; 
UPDATE  $p{settings_table} SET value = ? WHERE value = ? and setting = 'list';
UPDATE  $p{bounce_scores_table} SET list = ? WHERE list = ?; 
UPDATE  $p{clickthrough_url_log_table} SET list = ? WHERE list = ?; 
UPDATE  $p{mass_mailing_event_log_table} SET list = ? WHERE list = ?; 
UPDATE  $p{password_protect_directories_table} SET list = ? WHERE list = ?";

my @queries = split("\n", $query_string); 

require DADA::App::DBIHandle; 
my $dbi_obj = DADA::App::DBIHandle->new; 
my $dbh     = $dbi_obj->dbh_obj;


foreach my $query(@queries){ 
	my $sth = $dbh->prepare($query);
    my $rv =
      $sth->execute($new_name, $list)
      or croak "cannot do statement! $DBI::errstr\n";
}

require DADA::App::ScreenCache; 
my $c = DADA::App::ScreenCache->new; 
   $c->flush;


print $q->redirect(-uri => $DADA::Config::S_PROGRAM_URL . '?f=logout&login_url='. $DADA::Config::S_PROGRAM_URL . '?f=' . $DADA::Config::ADMIN_FLAVOR_NAME); 

}
=pod

=head1 Plugin: change_list_shortname.cgi - Change your mailing list's Short Name

Your mailing list's, B<Short Name> is what Dada Mail uses as a unique identifier internally to tell your mailing list apart from every other mailing list. This Short Name is picked out, when you create your mailing list. Although used internally, you may also see it in the various query strings Dada Mail sets for navigation and email confirmations. 

Because of this public view, or an otherwise internal name, you may want to I<change> the List Short Name. Perhaps you picked out a really bad Short Name like, B<temporarytest> or B<listthree> and you've found that your mailing list isn't so temporary, or it's the only mailing list you have, instead of being in a series. 

This plugin allows you to change your List Short Name

=head2 CAVEATS

There's some major caveats when using this plugin, that you want to be aware of, before using it to change your List Short Name

=head3 SQL backend-only

This plugin only works if you are using one of the SQL backends: B<MySQL>, B<PostgreSQL>, or B<SQLite>. It will not work with the B<Default> backend. 

=head3 Always make a backup of your complete database

We encourage you to make a backup of your complete SQL database, before using this plugin. Although checks are made to verify there won't be any problems with using a new List Short Name for a current mailing list, we still want you to err on the side of caution. 

=head3 Text Logs are not processed

This plugin works by changing the List Short Name found in the various tables in your SQL database that makes up your Dada Mail Mailing Lists. Text Logs, such as your error log or usage log are not touched. 

=head3 Potential Susbcription Form/Link Breakage

Any current static Subscription forms, and any subscription/unsubscription links embedded in already sent email messages will most likely B<break>, once you've changed your List Short Name. You will potentially need to update the Subscription forms located on your website, but there's nothing you can do with the links in any sent email messages. 


=head1 Installation 

This plugin can be installed during a Dada Mail install/upgrade, using the included installer that comes with Dada Mail. The below installation instructions go through how to install the plugin manually.

=head2 Change permissions of "change_list_shortname.cgi" to 755

The, C<change_list_shortname.cgi> plugin will be located in your, I<dada/plugins> diretory. Change the script to, C<755>

=head2 Configure your .dada_config file

Now, edit your C<.dada_config> file, so that it shows the plugin in the left-hand menu, under the, B<Plugins> heading: 

First, see if the following lines are present in your C<.dada_config> file: 

 # start cut for list control panel menu
 =cut

 =cut
 # end cut for list control panel menu

If they are, remove them. 

Then, find these lines: 

 #					{
 #					-Title      => 'Change Your List Short Name',
 #					-Title_URL  => $PLUGIN_URL."/change_list_shortname.cgi",
 #					-Function   => 'change_list_shortname',
 #					-Activated  => 0,
 #					},

Uncomment the lines, by taking off the, "#"'s: 

 					{
 					-Title      => 'Change Your List Short Name',
 					-Title_URL  => $PLUGIN_URL."/change_list_shortname.cgi",
 					-Function   => 'change_list_shortname',
 					-Activated  => 0,
 					},

Save your C<.dada_config> file.

You can now log into your List Control Panel (make sure to log in with the B<Dada Mail Root Password>) and under the, B<plugins> heading you should now see a linked entitled, "Change Your List Short Name". Clicking that link will bring you to this plugin. 

=head1 COPYRIGHT 

Copyright (c) 1999 - 2012 

Justin Simoni

http://justinsimoni.com

All rights reserved. 

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

=cut



