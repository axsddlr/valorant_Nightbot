# rainbowsix7nightbot
Rainbow 6: Siege chat commands for any Twitch.tv bot that has a an URI fetch command system.

**Does not work with:** *Moobot and any bot without advanced custom command system and variables. (Note: you can run Nightbot alongside any moderating chat bot by just not giving Nightbot moderator privileges. Nightbot will still reply to custom chat commands.)*  
**Works with:** *[Nightbot, Ankhbot, Deepbot](https://blog.thomassen.xyz/custom-apis/), Phantombot and probably more unknown.*  

Hey RB6: Siege Twitch streamers, I wrote a PHP script that uses the API statistics and gathers end-points of the rainbow6 profile page and forwards them to [Nightbot](http://nightbot.tv). I deployed it on [Heroku](http://heroku.com) and it is ready to use by everyone! 

This server-side script is making use of Nightbot's dynamic response system (mostly [$(urlfetch)](https://docs.nightbot.tv/commands/variables/urlfetch)) with which you are able to fetch the resources forwarded by my Heroku App.

Do not worry! Nothing is saved server-side.
This privat "API" is purely for “viewing” ressources!

  --------  
Example for Nightbot:

**How to add commands to Nightbot.**

With chat:  
["!commands add !command_name command_response"](https://docs.nightbot.tv/commands/commands)  
With interface:  
https://beta.nightbot.tv/commands/custom  
  
  --------  
  

Here's what the response should contain for Nightbot to reply with your current rank:  

    $(urlfetch http://rainbowsix7nightbot.herokuapp.com/rainbowsix7.php?platform=YourPlatformHere&nick=YourNickHere&command=rank)
- Adjust the URL parameters to fit your purposes.
- ?platform= *(xbl, psn or uplay.)*  
**xbl** for Xbox One,   
**psn** for PS4,  
**uplay** for PC.  
- &nick= *(Your nick on the specific platform.)*
- Specify a command after the *&command=* query parameter at the end of the URL in the $(urlfetch) method.   
In the example above I specified "*rank*" as for the current rank in the current season.  

Note:  
- **You CAN write custom text before and after $(urlfetch) in the response!**  
- Do NOT forget to close any opening parantheses '(' with a closing ')' at the end!  
- You can let the user search for a player himself by doing *?platform=$(1)&nick=$(2)*.
The user will have to put a platform and a nick as arguments separated by a space after your command.

  --------  
Other commands you can specify after *&command=* at this moment:  
 
- **rank**   

Example output: *"Gold Ⅳ - matchmaking rating: 4008"*  
You can specify **&region=** *(NA, EU or ASIA)* if you play on multiple regions with one account!  
Use *&region=$( ^number1-9 )* to catch and input arguments given by the user. Favourably a region.  
(You should also specify this to decrease response delay for rank.)  
  
- **stats**  

Example output: *"Lv.115 | 1.7 W/L ratio | 1.1 K/D ratio"* (Only ranked resources.)

- **time**  

Example output: *"238h 38m 24s"*  (time spent in multiplayer.)

  --------
Thread in the CustomAPI section on Nightbot.tv:
https://community.nightdev.com/t/customapi-tom-clancys-rainbow-six-siege-api-commands-unofficial

If there is demand for other commands ie. statistics I will add more.

# Common troubleshooting

**Problem:** Unable to fetch resources using gamer tags with spaces in the 'nick=' query parameter.  
**Solution:** Use the login nick you created your account with instead. (ie. your first nick ever.)  
**Solution 2:** Use your profileId which you can get from your profile URL at https://game-rainbow6.ubi.com/