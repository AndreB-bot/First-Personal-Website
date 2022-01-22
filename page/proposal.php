<?php
$project_details = json_decode($user_proposal->project_details);
$file_names = json_decode($user_proposal->imgs_filename);
$date = new DateTime($user_proposal->submission_date);
$description = substr($project_details->description, 0, 1227);
$dev_type = $project_details->chosen_dev_work;
$members = $project_details->members;
$budget = floatval($project_details->budget);

$buget = number_format($budget, 2);

$user_data = $dbQueriesManager->getUserData($username);
$user = new userEntity($user_data);
$address = json_decode($user->getAddress());

$members_div = makeMembersDivs();

function makeMembersDivs() {
    global $members;
    global $user;
    global $file_names;

    $div = "";
    $count = 0;
    $folder = $user->getAssignedFolder();

    foreach ($members as $member => $position) {
        $img_name = $file_names[$count];

        if (!$img_name) {
            $path = "defualt.png";
        } else {
            $path = "$folder/$img_name";
        }

        $div .= "<div class=\"memeber-details\">"
                . "<img src=\"../cdn/$path\" width=\"110\" "
                . "height=\"90\" alt=\"$member\"/>"
                . "<div><p class=\"name\">$member</p>"
                . "<p class=\"title\">$position</p></div></div>";
        $count++;
    }

    return $div;
}
?>




<section id="project-sub-wrapper">
    <div id="project-sub-container">
        <!-- Slideshow container -->
        <div class="slideshow-container">

            <!-- F -->
            <div class="slides">
                <div class="numbertext">1 / 5</div>
                <div class="co-title-container">
                    <div>
                        <div class="page1-title">
                            <p><?php echo $project_details->title; ?>:</p>
                        </div>
                        <div class="page1-subtitle">
                            <p><?php echo "A $dev_type Solution" ?></p>
                        </div>
                    </div>
                </div>
                <div class="type-of-proposal">
                    <div>
                        <p style="font-size: 2.5rem;" class="align-right" >Product Proposal</p>
                        <p class="align-right"><?php echo $date->format("F d Y") ?></p>
                    </div>
                    <div>
                        <p style="font-family:'Istok Web'; font-size: 1.5rem;" class="align-right uppercase">
                            <?php echo "Prepared for " . $user->getCompanyName() ?>
                        </p>
                    </div>
                </div>
                <div id="project-logo"><p>AÉB Software Consultancy</p> </div>
                <img src="../css/imgs/bkgrP1.png" width="635" height="883">
                <div class="text">Page 1</div>
            </div>

            <!-- S -->
            <div class="second slides">
                <div class="numbertext">2 / 5</div>
                <div id="greetings-container">
                    <div id="greetings-title">
                        <p>Greeting from AÉB Software Consultancy!</p>
                    </div>
                    <div style="margin-top: 31%;font-weight: bold;">
                        <p>
                            We are a data-driven, customer-centric web and app development company.
                        </p>
                        <p>
                            We are obsessed with empowering businesses to work quicker and better, 
                            through responsive technology.
                        </p>
                    </div>
                </div>

                <img src="../css/imgs/bkgP2.png" width="635" height="883">
                <div class="text">Page 2</div>
            </div>

            <!-- T -->
            <div class="slides">
                <div class="numbertext">3 / 5</div>
                <div id="about-client">
                    <div>
                        <p style="color: #ffffff;font-size: 3.5rem;font-weight: bolder;">
                            <?php echo "About " . $user->getCompanyName() ?>
                        </p>
                    </div>
                    <div>
                        <p style="color: white;">
                            <?php echo $user->getIntro() ?: "They haven't told us anything about themselves yet...must be shy..."; ?> 
                        </p>
                    </div>
                </div>
                <div id="intro-to-team">
                    <p><?php echo "The " . $user->getCompanyName() . " Team"; ?></p>
                </div>
                <p style="color: rgb(160, 102, 203);position: absolute;top: 50.6%;left: 15%;font-size: 1.5rem;font-weight: bold;" id="memebers-p">Members</p>
                <div id="members">
                    <?php echo $members_div ?>
                </div>   
                <img src="../css/imgs/bkgrP3.PNG" width="635" height="883" >
                <div class="text">Page 3</div>
            </div>
            <div class="slides">
                <div class="numbertext">4 / 5</div>
                <div id="project-description">
                    <h3 style="font-weight: bolder;color: #1836b2;">Project Description</h3>
                    <p style="font-weight: 600;margin-top: 5%;">
                        <?php echo $description; ?>
                    </p>
                </div>
                <img style="position: absolute;top: 68%;left: 10%;opacity: 0.7;" src="../css/imgs/specs.png" width="500" height="200" alt=""/>
                <img src="../css/imgs/bkgrP4.PNG" width="635" height="883">
                <div class="text">Page 4</div>
            </div>

            <div class="slides">
                <div id="heading1">
                    <p class="heading">
                        <?php echo "<p>Bringing</p><p>" . $project_details->title . "</p><p>To Life</p>"; ?>
                    </p>
                </div>
                <div id="development-cost">
                    <p id="first-child">Development Cost</p>
                    <p id="last-child">
                        The working budget is $<?php echo $buget ?>, including the research done, the initial wire framing and user testing, and the beta launch with predetermined partner companies.
                    </p>
                </div>
                <div id="heading2">
                    <p class="heading">
                        Contact Details
                    </p>
                </div>
                <div id="contact-details">
                    <p> <?php echo $user->getFirstName() . " " . $user->getLastName(); ?></p>
                    <p><?php echo $user->getCompanyName(); ?></p>
                    <p><?php echo $address->street_address; ?></p>
                    <p><?php echo $address->city; ?></p>
                    <p><?php echo $address->province; ?></p>
                    <p><?php echo $address->post_code; ?></p>
                    <p><?php echo $user->getEmail(); ?></p>
                </div>


                <div id="heading3">
                    <p class="heading">
                        Status
                    </p>
                </div>
                <img id="review-status" src="../css/imgs/under-review.png" width="500" height="200" alt="Approval Status"/>
                <div class="numbertext">5 / 5</div>
                <img src="../css/imgs/bkgrP5.png" width="635" height="883">
                <div class="text">Page 5</div>
            </div>

            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <div id="comment-container">
            <div>
                <?php
                $comments = $dbQueriesManager->getUserComments($username);
                if (!empty($comments)) {
                    echo "<p style=\"font-size: 2.5rem;\">Comments</p>";
                }
                ?>
                <ol id="posts-list" class="hfeed">
                    <?php
                    if (empty($comments)) {
                        echo '<li class="no-comments">Be the first to add a comment.</li>';
                    } else {

                        foreach ($comments as $comment) {

                            $id = $comment['id'];
                            $date = date('d F Y', strtotime($comment['date']));
                            $user_comment = $comment['comment'];
                            $comment_author = $comment['username'];

                            echo "
                    <li><article id=\"comment_$id\" class=\"hentry\">"
                            . "<footer class=\"post-info\">"
                            . " <abbr class=\"published\" title=\"$date\">"
                            . "$date"
                            . "</abbr>"
                            . "<address class=\"vcard author\">"
                            . "By <a class=\"url fn\" href=\"#\">$comment_author</a>"
                            . "</address>"
                            . "</footer>"
                            . "<div class=\"entry-content\">"
                            . "<p>$user_comment</p>"
                            . "</div>"
                            . "</article></li>";
                        }
                    }
                    ?>
                </ol>

                <div id = "respond">
                    <h3>Leave a Comment</h3>
                    <form id="commentform">
                        <label for = "comment" class="required">Your message:</label>
                        <textarea name="comment" id="comment" rows = "10" tabindex="4" required></textarea>
                        <input id = "comment-submit" name="submit" type="submit"  class="btn" value="Submit comment" />
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script src = "../assets/js/slider.js"></script>
    <script src = "../assets/js/comments.js"></script>
</section>
