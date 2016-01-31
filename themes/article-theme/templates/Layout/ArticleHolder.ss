<div id="content">
    <div id="posts">
        <% loop $Articles %>
            <div class="post">
                <h3>$Teaser</h3>
                <div><span class="date"><b>$Date.Long</b></span><span class="categories"><b>in: Photos, Retro</b></span></div>
                <div class="description">
                    <p>
                        <% with $Photo.CroppedImage(100,80) %>
                            <img src="$URL" alt="" width="$Width" height="$Height"/>
                        <% end_with %>
                        <% if $Teaser %>
                            $Teaser
                        <% else %>
                            $Description.FirstSentence
                        <% end_if %>
                    </p>
                    <p class="comments">Comments - <a href="#">17</a>   <span>|</span>   <a href="$Link">Read more...</a></p>
                </div>
            </div>
        <% end_loop %>
    </div>
    <% include SideBar %>
</div>
