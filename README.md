# Valorant_Nightbot
Valorant chat commands for any Twitch.tv bot that has a an URI fetch command system.

**Does not work with:** *Moobot and any bot without advanced custom command system and variables. (Note: you can run Nightbot alongside any moderating chat bot by just not giving Nightbot moderator privileges. Nightbot will still reply to custom chat commands.)*  
**Works with:** *[Nightbot, Ankhbot, Deepbot](https://blog.thomassen.xyz/custom-apis/), Phantombot and probably more unknown.*  

Hey Valorant: Siege Twitch streamers, I wrote a PHP script that uses the API statistics and gathers end-points of the rainbow6 profile page and forwards them to [Nightbot](http://nightbot.tv). I deployed it on [Heroku](http://heroku.com) and it is ready to use by everyone! 

This server-side script is making use of Nightbot's dynamic response system (mostly [$(urlfetch)](https://docs.nightbot.tv/commands/variables/urlfetch)) with which you are able to fetch the resources forwarded by my Heroku App.

Do not worry! Nothing is saved server-side.
This privat "API" is purely for “viewing” ressources!

<p><a href="https://heroku.com/deploy" rel="nofollow"><img src="https://camo.githubusercontent.com/c0824806f5221ebb7d25e559568582dd39dd1170/68747470733a2f2f7777772e6865726f6b7563646e2e636f6d2f6465706c6f792f627574746f6e2e706e67" alt="Deploy to Heroku" data-canonical-src="https://www.herokucdn.com/deploy/button.png" style="max-width:100%;"></a></p>

  --------  
Example for Nightbot:

**How to add commands to Nightbot.**

With chat:  
["!commands add !command_name command_response"](https://docs.nightbot.tv/commands/commands)  
With interface:  
https://beta.nightbot.tv/commands/custom  
  
  --------  
  

Here's what the response should contain for Nightbot to reply with your current rank:  

    $(urlfetch https://valorant-nightbot.herokuapp.com/valorant-stats.php?nick=(Name)&tag=(ID number after #)&command=(stats or rank)';
- Adjust the URL parameters to fit your purposes.
- &nick= *(Your nick on the specific platform.)*\
- &tag= *(Your numbers or characters after '#')*
- Specify a command after the *&command=* query parameter at the end of the URL in the $(urlfetch) method.   
In the example above I specified "*rank*" or "*stats*" as for the current rank in the current season.  

Note:  
- **You CAN write custom text before and after $(urlfetch) in the response!**  
- Do NOT forget to close any opening parantheses '(' with a closing ')' at the end!  
- You can let the user search for a player himself by doing *?nick=$(1)&tag=$(2)*.
The user will have to put a platform and a nick as arguments separated by a space after your command.

  --------  
Other commands you can specify after *&command=* at this moment:  
 
- **rank**   

Example output: *"Gold 1 (rehkloos#001)"*   
  
- **stats**  

Example output: *"Lv.115 | 1.7 W/L ratio | 1.1 K/D ratio"* (Only ranked resources.)

- **time**  

Example output: *"238h 38m 24s"*  (time spent in multiplayer.)

  --------
If there is demand for other commands ie. statistics I will add more.

# Common troubleshooting

**Problem:** Unable to fetch resources using gamer tags with spaces in the 'nick=' query parameter.  
**Solution:** Use the login nick you created your account with instead. (ie. your first nick ever.)  
**Solution 2:** Use your profileId which you can get from your profile URL at https://game-rainbow6.ubi.com/
