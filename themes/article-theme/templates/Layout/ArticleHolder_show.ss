<div id="content">
   <div id="posts">
        <% with $Article %>
        <div class="post">
            <h2>$Teaser</h2>
            <div><span class="date">$Date.Long</span><span class="categories">in: Photos, Retro</span></div>
            <div class="description">
                <p>
                    <% with $Photo.CroppedImage(239,232) %>
                        <img src="$URL" alt="" width="$Width" height="$Height"/>
                    <% end_with %>
                    $Description
                </p>
            </div>
        </div>
        <% end_with %>
        <div id="comments">
            <img src="$ThemeDir/images/title3.gif" alt="" width="216" height="39" /><br />
            <% loop $Comments %>
                <div class="comment">
                    <div class="avatar">
                        <img src="$ThemeDir/images/avatar2.gif" alt="" width="80" height="80" /><br />
                        <span>$Name</span><br />
                        $Created.Format('j F, Y')
                    </div>
                    <p>$Comment</p>
                </div>
            <% end_loop %>

            <div id="add">
                <img src="$ThemeDir/images/title4.gif" alt="" width="216" height="47" class="title" /><br />
                <div class="avatar">
                    <img src="$ThemeDir/images/avatar2.gif" alt="" width="80" height="80" /><br />
                </div>
                <div class="form">
                        $CommentForm
                </div>
            </div>
        </div>
    </div>

    <% include SideBar %>
 </div>