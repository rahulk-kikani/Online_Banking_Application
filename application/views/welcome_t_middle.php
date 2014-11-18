<div class="content_area">
<?php
                        if(isset($page))
                        {
                            $this->load->view('welcome_template/'.$page);
                        }
                        else
                        {
                            echo "Error : 404 Page Not Found.";
                        }
        ?>
        </div>
