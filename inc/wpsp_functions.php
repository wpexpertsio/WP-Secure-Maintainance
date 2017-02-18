<?php

/**
 * @author Mohammad Mursaleen
 * function to add PIN protection functionality
 */
if ( !is_admin() && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) )   ) :


function wpsp_display_security_form(){


        if( wpsp_get_option('enable') != 'on' )  // check if this functionality is enabled
            return false;


        $pin = wpsp_get_option('pin');  // Get saved PIN


        if ( isset($_COOKIE['wpsp_pass']) && $pin == $_COOKIE['wpsp_pass'] ) // to check if PIN cookie exist
            return false;


        if (( isset($_POST['page_password']) && $pin == $_POST['page_password']) ) {

            setcookie('wpsp_pass', $pin , 0 , '/' );  // set password in cookie

            return false;

        } else {

            ?>
            <style>
                body {
                    background-color: rgba(95, 158, 190, 0.22) !important
                }
                img.wpsp-logo {
                    border-radius: 50%;
                    box-shadow: 5px 5px 5px #5a5a5a;
                    text-align: center;
                    margin: 0px auto 0px auto;
                    margin-top: 5%;
                    position: relative;
                }
                .style input[type="password"] {
                    padding: 10px 0px 5px 0px;
                }

                .objects_password_form {
                    margin-bottom: 20px;
                    text-align: center;
                    font-size: 13px;
                    font-family: sans-serif;
                    font-weight: bold;
                }
                .container{
                    width: 100%;
                    margin: 0 auto;
                }

                /*for button*/
                .wpsp-submit-button {
                    background: #313131;
                    border-radius: 5px;
                    padding: 10px 20px;
                    color: #FFFFFF;
                    font-size: 17px;
                    margin-top: 20px;
                }

                .wpsp-logo-div {
                    text-align: center;
                    margin-bottom: 20px;
                }
                input#user_pass{
                    /* color: rgba(255, 255, 255, 0.89) !important;*/
                }
                input#user_pass , input#user_pass:focus {
                    background: none;
                    border: none;
                    border-bottom: 1px solid #000000;
                }

                input#user_pass {
                    font-size: 15px;
                }
                textarea:focus, input:focus{
                    outline: none;
                }
                .wrapper {
                    padding: 20px;
                    background-color: #fff;
                    border: 1px solid #fff;
                    width: 300px;
                    max-width: 80%;
                    margin: 20px auto 0 auto;
                    box-shadow: 10px 10px 15px #B8D0DC;
                }
            </style>
            <div class="container" >
                <div class="wpsp-logo-div">
                    <?php  if( wpsp_get_option('logo_image') != false ){ $logo_url = wpsp_get_option('logo_image'); } else { $logo_url =  plugins_url( 'img/default-logo.png', dirname(__FILE__) ); }?>
                    <img class="wpsp-logo" style="height:<?php echo wpsp_get_option('logo_width'); ?>  !important; width:<?php echo wpsp_get_option('logo_height'); ?> !important;" src="<?php echo $logo_url; ?>" alt="" >
                </div>
                <div class="wrapper">
                    <div class="objects_password_form style">
                        <form action="" method="post" >
                            <!-- <label> &nbsp;</label>-->
                            <input id="user_pass" placeholder="<?php echo wpsp_get_option('pin_placeholder'); ?>" type="password" name="page_password">
                            <br>
                            <input  type="submit" class="wpsp-submit-button" value="<?php echo wpsp_get_option('submit_label'); ?>">
                        </form>
                        <?php
                        if(isset($_POST['page_password']))
                            echo '<p class="error" style="color:#ff5348;">'.wpsp_get_option('try_again_error') . '</p>'. '<br>';

                        ?>
                    </div>
                </div>
            </div>
            <?php

            die();

        }

}
add_action('init','wpsp_display_security_form',20 );


endif;