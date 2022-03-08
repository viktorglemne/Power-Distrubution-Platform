## Versions
The different versions have been collected as milestones for what we have reached during the development process. A full list of every commit can be seen on [github](https://github.com/JunkZ/M7011E-DynamicPage/commits/master) or the [commit log](gitlog.txt)

| Version| Date            | Function | Comment  | approximate time (hours)|
| ---    | ----------      |          |          |              |
| `1.2`  | January 11 2022 |Additional security, docs and general fixes          |Encrypted token check on simulator updates. More work on documentation and general fixes mosty based on the new file structure          |6              |
| `1.1`  | January 5 2022  |Docs, API, security & directory update       | Initial documentation. API interface for retriving user-specific data not just general data. Use of encrypted passwords to access user data. Overhaul of file structure.          | 14              |
| `1.0`  | December 27 2021|Readme, QOL fixes          | Feature complete. Initial README. Small QOL fixes include changing only password, more information on userpage & second ratio for market buying        | 8              |
| `0.9`  | December 14 2021|Price logic, coal plant and more charts         |More charts to display user consumtion/production relative to entire userbase. Price now based on avaible buffer and wind speed. Seperate coal powerplant for admins to manipulate.       | 13              |
| `0.8`  | December 6 2021 |Data charts          |Pretty charts to display buffer/price and wind history charts          |  7            | 
| `0.7`  | November 29 2021|Blocking feature and expanded design          |Added a blocking users feature to admins to lock users from the market and site. Userlist showing whos online, and other small design changes        | 8              |
| `0.6`  | November 23 2021|Admin page, profile pictures & settings, GET interface      |The addition of an admin only page with the power to edit and delete users. The ability to upload and display a profile picture. A user settings page and drop-down menu for the navbar. The first access point to the service, returning json formated data of total buffer size and current price          |16             |
| `0.5`  | November 18 2021|Simulator and post interface          |Simulator for random wind speeds and regular buffer and price updates was added. Also several fixes regarding user profiles|10              |
| `0.4.1`  | November 15 2021|Expanded userpage          |Expanded the design of userpage with tables and more information like user buffer size and ratios          |6              |
| `0.4`  | November 12 2021|Userpage          |Implemented a userpage displaying basic data about production and consumption          | 8             |
| `0.3`  | November 11 2021|Navbar, sessions & consumption          |Initial navbar implemented. User sessions across site vists enabled and start of keeping track/changing users consumption          |14              |
| `0.2`  | November 8 2021 |Wind speed API          |Enabled retriving windspeed from external API (Vindkraftsstatisik) and expanded login page. Wind api was replaced (but still functional) in favor of simulating random values        |7           |
| `0.1.1`| November 5 2021 |Login & admin   | Initial database communication logic. Expanded db schema with login feature and admin flags. Initial login page        | 6            |
| `0.1`  | November 4 2021 |Web Design & DB | First concrete development. Initial DB setup, index and basic design| 8            |
| `0.0`  | < November 4 2021  |Design decisions| Theoritcal design and development decisions. Choice of system structure and tools to be used | 10             |

In the development of the system and API we have committed 127 different updates in ~140 working hours.
