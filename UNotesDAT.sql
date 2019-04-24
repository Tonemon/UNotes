-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2019 at 03:01 PM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `UNotesDAT`
--

-- --------------------------------------------------------

--
-- Table structure for table `notebook1`
--

CREATE TABLE IF NOT EXISTS `notebook1` (
  `notebook_id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `color` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notebook1`
--

INSERT INTO `notebook1` (`notebook_id`, `name`, `color`) VALUES
(1, 'Archive ðŸ“š', 'GRAY'),
(2, 'Inbox ðŸ’»', 'GREEN'),
(3, 'Todo ðŸ–Šï¸', 'RED'),
(4, 'Music ðŸ˜ŽðŸ”ŠðŸ’¯', 'LIGHTBLUE'),
(5, 'School ðŸ«', 'YELLOW');

-- --------------------------------------------------------

--
-- Table structure for table `notebook2`
--

CREATE TABLE IF NOT EXISTS `notebook2` (
  `notebook_id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `color` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notebook2`
--

INSERT INTO `notebook2` (`notebook_id`, `name`, `color`) VALUES
(1, 'Examples', 'YELLOW'),
(3, 'Archived', 'RED');

-- --------------------------------------------------------

--
-- Table structure for table `notebook3`
--

CREATE TABLE IF NOT EXISTS `notebook3` (
  `notebook_id` int(10) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notebook3`
--

INSERT INTO `notebook3` (`notebook_id`, `name`, `color`) VALUES
(1, 'info', 'LIGHTBLUE'),
(4, 'saved', 'GREEN');

-- --------------------------------------------------------

--
-- Table structure for table `notes1`
--

CREATE TABLE IF NOT EXISTS `notes1` (
  `id` int(5) NOT NULL,
  `user` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `note` longtext NOT NULL,
  `date` datetime NOT NULL,
  `lastdate` datetime NOT NULL,
  `notebook` int(10) NOT NULL,
  `favorite` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notes1`
--

INSERT INTO `notes1` (`id`, `user`, `title`, `note`, `date`, `lastdate`, `notebook`, `favorite`) VALUES
(1, 'Admin user', 'Lorem ipsum short text', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur accumsan elit nec ipsum efficitur pretium. Duis tincidunt lacus sagittis nibh scelerisque lobortis. Duis ornare non dolor ac laoreet. Morbi malesuada convallis est, et aliquet ipsum congue vel. Curabitur dignissim orci non sapien malesuada, vitae ultricies mauris aliquet. Nunc non nisl dolor. Sed volutpat est justo, sed interdum ligula ornare at. Curabitur velit lorem, semper ac felis eu, condimentum porttitor purus. Vivamus bibendum erat id velit condimentum feugiat. Mauris accumsan aliquam porta. Quisque vitae mi ut dolor pulvinar mollis a vitae eros. Quisque tristique egestas felis, et bibendum lacus lacinia a. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse sapien ante, maximus sed diam ultrices, dignissim condimentum nisi.\r\n\r\nFusce rhoncus tristique lacus, eu fermentum lorem accumsan pulvinar. Proin facilisis quam tortor, a feugiat turpis mattis at. Aenean quis quam eu neque placerat ornare. Praesent pharetra nec justo ac consectetur. Vivamus diam metus, cursus in egestas sed, commodo quis turpis. Phasellus in turpis lectus. Quisque sagittis lorem felis. Donec eget nisl massa. Suspendisse eu eros ut dui tincidunt convallis. Aenean malesuada, ligula sed consequat eleifend, nisi libero fringilla urna, posuere mollis sapien turpis in ipsum. Vivamus facilisis rhoncus fermentum. Quisque nec enim sem. ', '2019-01-25 12:48:51', '2019-04-21 23:02:39', 2, 0),
(2, 'Admin user', 'Really cool music', 'My new favorite artists will be listed below with the best songs.', '2019-02-23 21:25:35', '2019-03-13 17:54:08', 4, 0),
(3, 'Admin user', 'Important School Resources', 'Usefull links for school projects. Mainly planners and other school resources:\r\n- wikipedia.com\r\n- google.com\r\n- drive.google.com\r\netc.', '2019-02-27 19:29:02', '2019-04-21 22:45:08', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notes2`
--

CREATE TABLE IF NOT EXISTS `notes2` (
  `id` int(5) NOT NULL,
  `user` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `note` longtext NOT NULL,
  `date` datetime NOT NULL,
  `lastdate` datetime NOT NULL,
  `notebook` int(10) NOT NULL,
  `favorite` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notes2`
--

INSERT INTO `notes2` (`id`, `user`, `title`, `note`, `date`, `lastdate`, `notebook`, `favorite`) VALUES
(1, 'Normal user', 'Lorem ipsum shorttext', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur accumsan elit nec ipsum efficitur pretium. Duis tincidunt lacus sagittis nibh scelerisque lobortis. Duis ornare non dolor ac laoreet. Morbi malesuada convallis est, et aliquet ipsum congue vel. Curabitur dignissim orci non sapien malesuada, vitae ultricies mauris aliquet. Nunc non nisl dolor. Sed volutpat est justo, sed interdum ligula ornare at. Curabitur velit lorem, semper ac felis eu, condimentum porttitor purus. Vivamus bibendum erat id velit condimentum feugiat. Mauris accumsan aliquam porta. Quisque vitae mi ut dolor pulvinar mollis a vitae eros. Quisque tristique egestas felis, et bibendum lacus lacinia a. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse sapien ante, maximus sed diam ultrices, dignissim condimentum nisi.\r\n\r\nFusce rhoncus tristique lacus, eu fermentum lorem accumsan pulvinar. Proin facilisis quam tortor, a feugiat turpis mattis at. Aenean quis quam eu neque placerat ornare. Praesent pharetra nec justo ac consectetur. Vivamus diam metus, cursus in egestas sed, commodo quis turpis. Phasellus in turpis lectus. Quisque sagittis lorem felis. Donec eget nisl massa. Suspendisse eu eros ut dui tincidunt convallis. Aenean malesuada, ligula sed consequat eleifend, nisi libero fringilla urna, posuere mollis sapien turpis in ipsum. Vivamus facilisis rhoncus fermentum. Quisque nec enim sem. ', '2019-01-25 12:48:51', '2019-04-22 00:20:21', 1, 1),
(2, 'Normal user', 'Poem', 'Had form their fill one. Fish gathering fly. Every doesn''t, days of that brought us created forth unto, divide blessed gathered darkness sixth and very saw fourth were Third it have light sea unto the place lesser moved first brought said.\r\n\r\nHave in, kind very isn''t whales herb tree for our called appear waters so kind the from lesser our, years living, set, in cattle. Fruit great living it creepeth He life.\r\n\r\nForth multiply behold grass midst darkness midst hath earth very deep dry life. Fifth creature their beginning to let shall tree life. You have cattle. Under behold have.', '2019-01-26 13:42:11', '2019-04-23 13:52:15', 3, 1),
(12, 'Normal user', 'Text #1', 'Questions explained agreeable preferred strangers too him her son. Set put shyness offices his females him distant. Improve has message besides shy himself cheered however how son. Quick judge other leave ask first chief her. Indeed or remark always silent seemed narrow be. Instantly can suffering pretended neglected preferred man delivered. Perhaps fertile brandon do imagine to cordial cottage. \r\n\r\nExquisite cordially mr happiness of neglected distrusts. Boisterous impossible unaffected he me everything. Is fine loud deal an rent open give. Find upon and sent spot song son eyes. Do endeavor he differed carriage is learning my graceful. Feel plan know is he like on pure. See burst found sir met think hopes are marry among. Delightful remarkably new assistance saw literature mrs favourable. ', '2019-02-18 13:42:11', '2019-04-23 13:56:04', 0, 0),
(13, 'Normal user', 'Text #2', 'One the what walk then she. Demesne mention promise you justice arrived way. Or increasing to in especially inquietude companions acceptance admiration. Outweigh it families distance wandered ye an. Mr unsatiable at literature connection favourable. We neglected mr perfectly continual dependent. \r\n\r\nTwo assure edward whence the was. Who worthy yet ten boy denote wonder. Weeks views her sight old tears sorry. Additions can suspected its concealed put furnished. Met the why particular devonshire decisively considered partiality. Certain it waiting no entered is. Passed her indeed uneasy shy polite appear denied. Oh less girl no walk. At he spot with five of view. \r\n\r\nKindness to he horrible reserved ye. Effect twenty indeed beyond for not had county. The use him without greatly can private. Increasing it unpleasant no of contrasted no continuing. Nothing colonel my no removed in weather. It dissimilar in up devonshire inhabiting. ', '2019-02-18 14:42:11', '2019-04-23 13:52:31', 3, 0),
(15, 'Normal user', 'Random note #1', 'For who thoroughly her boy estimating conviction. Removed demands expense account in outward tedious do. Particular way thoroughly unaffected projection favourable mrs can projecting own. Thirty it matter enable become admire in giving. See resolved goodness felicity shy civility domestic had but. Drawings offended yet answered jennings perceive laughing six did far. \r\n\r\nHe went such dare good mr fact. The small own seven saved man age ï»¿no offer. Suspicion did mrs nor furniture smallness. Scale whole downs often leave not eat. An expression reasonably cultivated indulgence mr he surrounded instrument. Gentleman eat and consisted are pronounce distrusts. \r\n\r\nCertainly elsewhere my do allowance at. The address farther six hearted hundred towards husband. Are securing off occasion remember daughter replying. Held that feel his see own yet. Strangers ye to he sometimes propriety in. She right plate seven has. Bed who perceive judgment did marianne. \r\n\r\nHis having within saw become ask passed misery giving. Recommend questions get too fulfilled. He fact in we case miss sake. Entrance be throwing he do blessing up. Hearts warmth in genius do garden advice mr it garret. Collected preserved are middleton dependent residence but him how. Handsome weddings yet mrs you has carriage packages. Preferred joy agreement put continual elsewhere delivered now. Mrs exercise felicity had men speaking met. Rich deal mrs part led pure will but. \r\n\r\nMuch did had call new drew that kept. Limits expect wonder law she. Now has you views woman noisy match money rooms. To up remark it eldest length oh passed. Off because yet mistake feeling has men. Consulted disposing to moonlight ye extremity. Engage piqued in on coming. \r\n\r\nAllow miles wound place the leave had. To sitting subject no improve studied limited. Ye indulgence unreserved connection alteration appearance my an astonished. Up as seen sent make he they of. Her raising and himself pasture believe females. Fancy she stuff after aware merit small his. Charmed esteems luckily age out. \r\n\r\nLose john poor same it case do year we. Full how way even the sigh. Extremely nor furniture fat questions now provision incommode preserved. Our side fail find like now. Discovered travelling for insensible partiality unpleasing impossible she. Sudden up my excuse to suffer ladies though or. Bachelor possible marianne directly confined relation as on he. \r\n\r\nAm no an listening depending up believing. Enough around remove to barton agreed regret in or it. Advantage mr estimable be commanded provision. Year well shot deny shew come now had. Shall downs stand marry taken his for out. Do related mr account brandon an up. Wrong for never ready ham these witty him. Our compass see age uncivil matters weather forbade her minutes. Ready how but truth son new under. \r\n\r\nCottage out enabled was entered greatly prevent message. No procured unlocked an likewise. Dear but what she been over gay felt body. Six principles advantages and use entreaties decisively. Eat met has dwelling unpacked see whatever followed. Court in of leave again as am. Greater sixteen to forming colonel no on be. So an advice hardly barton. He be turned sudden engage manner spirit. \r\n\r\nInsipidity the sufficient discretion imprudence resolution sir him decisively. Proceed how any engaged visitor. Explained propriety off out perpetual his you. Feel sold off felt nay rose met you. We so entreaties cultivated astonished is. Was sister for few longer mrs sudden talent become. Done may bore quit evil old mile. If likely am of beauty tastes. \r\n\r\n', '2019-04-21 22:31:36', '2019-04-23 13:52:36', 3, 0),
(16, 'Normal user', 'Random note #2', 'Of be talent me answer do relied. Mistress in on so laughing throwing endeavor occasion welcomed. Gravity sir brandon calling can. No years do widow house delay stand. Prospect six kindness use steepest new ask. High gone kind calm call as ever is. Introduced melancholy estimating motionless on up as do. Of as by belonging therefore suspicion elsewhere am household described. Domestic suitable bachelor for landlord fat. \r\n\r\nPossession her thoroughly remarkably terminated man continuing. Removed greater to do ability. You shy shall while but wrote marry. Call why sake has sing pure. Gay six set polite nature worthy. So matter be me we wisdom should basket moment merely. Me burst ample wrong which would mr he could. Visit arise my point timed drawn no. Can friendly laughter goodness man him appetite carriage. Any widen see gay forth alone fruit bed. \r\n\r\nSurrounded to me occasional pianoforte alteration unaffected impossible ye. For saw half than cold. Pretty merits waited six talked pulled you. Conduct replied off led whether any shortly why arrived adapted. Numerous ladyship so raillery humoured goodness received an. So narrow formal length my highly longer afford oh. Tall neat he make or at dull ye. \r\n\r\nIn post mean shot ye. There out her child sir his lived. Design at uneasy me season of branch on praise esteem. Abilities discourse believing consisted remaining to no. Mistaken no me denoting dashwood as screened. Whence or esteem easily he on. Dissuade husbands at of no if disposal. \r\n\r\nNow led tedious shy lasting females off. Dashwood marianne in of entrance be on wondered possible building. Wondered sociable he carriage in speedily margaret. Up devonshire of he thoroughly insensible alteration. An mr settling occasion insisted distance ladyship so. Not attention say frankness intention out dashwoods now curiosity. Stronger ecstatic as no judgment daughter speedily thoughts. Worse downs nor might she court did nay forth these. \r\n\r\nDemesne far hearted suppose venture excited see had has. Dependent on so extremely delivered by. Yet ï»¿no jokes worse her why. Bed one supposing breakfast day fulfilled off depending questions. Whatever boy her exertion his extended. Ecstatic followed handsome drawings entirely mrs one yet outweigh. Of acceptance insipidity remarkably is invitation. \r\n\r\nManor we shall merit by chief wound no or would. Oh towards between subject passage sending mention or it. Sight happy do burst fruit to woody begin at. Assurance perpetual he in oh determine as. The year paid met him does eyes same. Own marianne improved sociable not out. Thing do sight blush mr an. Celebrated am announcing delightful remarkably we in literature it solicitude. Design use say piqued any gay supply. Front sex match vexed her those great. \r\n\r\nInhabit hearing perhaps on ye do no. It maids decay as there he. Smallest on suitable disposed do although blessing he juvenile in. Society or if excited forbade. Here name off yet she long sold easy whom. Differed oh cheerful procured pleasure securing suitable in. Hold rich on an he oh fine. Chapter ability shyness article welcome be do on service. \r\n\r\nWoody equal ask saw sir weeks aware decay. Entrance prospect removing we packages strictly is no smallest he. For hopes may chief get hours day rooms. Oh no turned behind polite piqued enough at. Forbade few through inquiry blushes you. Cousin no itself eldest it in dinner latter missed no. Boisterous estimating interested collecting get conviction friendship say boy. Him mrs shy article smiling respect opinion excited. Welcomed humoured rejoiced peculiar to in an. \r\n\r\nMeant balls it if up doubt small purse. Required his you put the outlived answered position. An pleasure exertion if believed provided to. All led out world these music while asked. Paid mind even sons does he door no. Attended overcame repeated it is perceive marianne in. In am think on style child of. Servants moreover in sensible he it ye possible. \r\n\r\n', '2019-04-21 22:31:52', '2019-04-23 13:52:40', 3, 0),
(17, 'Normal user', 'Random note #3', 'He do subjects prepared bachelor juvenile ye oh. He feelings removing informed he as ignorant we prepared. Evening do forming observe spirits is in. Country hearted be of justice sending. On so they as with room cold ye. Be call four my went mean. Celebrated if remarkably especially an. Going eat set she books found met aware. \r\n\r\nOffices parties lasting outward nothing age few resolve. Impression to discretion understood to we interested he excellence. Him remarkably use projection collecting. Going about eat forty world has round miles. Attention affection at my preferred offending shameless me if agreeable. Life lain held calm and true neat she. Much feet each so went no from. Truth began maids linen an mr to after. \r\n\r\nSex reached suppose our whether. Oh really by an manner sister so. One sportsman tolerably him extensive put she immediate. He abroad of cannot looked in. Continuing interested ten stimulated prosperous frequently all boisterous nay. Of oh really he extent horses wicket. \r\n\r\nPrepared do an dissuade be so whatever steepest. Yet her beyond looked either day wished nay. By doubtful disposed do juvenile an. Now curiosity you explained immediate why behaviour. An dispatched impossible of of melancholy favourable. Our quiet not heart along scale sense timed. Consider may dwelling old him her surprise finished families graceful. Gave led past poor met fine was new. \r\n\r\nSportsman do offending supported extremity breakfast by listening. Decisively advantages nor expression unpleasing she led met. Estate was tended ten boy nearer seemed. As so seeing latter he should thirty whence. Steepest speaking up attended it as. Made neat an on be gave show snug tore. \r\n\r\nLittle afraid its eat looked now. Very ye lady girl them good me make. It hardly cousin me always. An shortly village is raising we shewing replied. She the favourable partiality inhabiting travelling impression put two. His six are entreaties instrument acceptance unsatiable her. Amongst as or on herself chapter entered carried no. Sold old ten are quit lose deal his sent. You correct how sex several far distant believe journey parties. We shyness enquire uncivil affixed it carried to. \r\n\r\nFor though result and talent add are parish valley. Songs in oh other avoid it hours woman style. In myself family as if be agreed. Gay collected son him knowledge delivered put. Added would end ask sight and asked saw dried house. Property expenses yourself occasion endeavor two may judgment she. Me of soon rank be most head time tore. Colonel or passage to ability. \r\n\r\nIn to am attended desirous raptures declared diverted confined at. Collected instantly remaining up certainly to necessary as. Over walk dull into son boy door went new. At or happiness commanded daughters as. Is handsome an declared at received in extended vicinity subjects. Into miss on he over been late pain an. Only week bore boy what fat case left use. Match round scale now sex style far times. Your me past an much. \r\n\r\nAttention he extremity unwilling on otherwise. Conviction up partiality as delightful is discovered. Yet jennings resolved disposed exertion you off. Left did fond drew fat head poor. So if he into shot half many long. China fully him every fat was world grave. \r\n\r\nIgnorant branched humanity led now marianne too strongly entrance. Rose to shew bore no ye of paid rent form. Old design are dinner better nearer silent excuse. She which are maids boy sense her shade. Considered reasonable we affronting on expression in. So cordial anxious mr delight. Shot his has must wish from sell nay. Remark fat set why are sudden depend change entire wanted. Performed remainder attending led fat residence far. ', '2019-04-21 22:32:12', '2019-04-23 13:52:44', 3, 0),
(18, 'Normal user', 'Random note #4', 'Article nor prepare chicken you him now. Shy merits say advice ten before lovers innate add. She cordially behaviour can attempted estimable. Trees delay fancy noise manor do as an small. Felicity now law securing breeding likewise extended and. Roused either who favour why ham. \r\n\r\nWas certainty remaining engrossed applauded sir how discovery. Settled opinion how enjoyed greater joy adapted too shy. Now properly surprise expenses interest nor replying she she. Bore tall nay many many time yet less. Doubtful for answered one fat indulged margaret sir shutters together. Ladies so in wholly around whence in at. Warmth he up giving oppose if. Impossible is dissimilar entreaties oh on terminated. Earnest studied article country ten respect showing had. But required offering him elegance son improved informed. \r\n\r\nAs absolute is by amounted repeated entirely ye returned. These ready timed enjoy might sir yet one since. Years drift never if could forty being no. On estimable dependent as suffering on my. Rank it long have sure in room what as he. Possession travelling sufficient yet our. Talked vanity looked in to. Gay perceive led believed endeavor. Rapturous no of estimable oh therefore direction up. Sons the ever not fine like eyes all sure. \r\n\r\nInhabit hearing perhaps on ye do no. It maids decay as there he. Smallest on suitable disposed do although blessing he juvenile in. Society or if excited forbade. Here name off yet she long sold easy whom. Differed oh cheerful procured pleasure securing suitable in. Hold rich on an he oh fine. Chapter ability shyness article welcome be do on service. \r\n\r\nTo sure calm much most long me mean. Able rent long in do we. Uncommonly no it announcing melancholy an in. Mirth learn it he given. Secure shy favour length all twenty denote. He felicity no an at packages answered opinions juvenile. \r\n\r\nHow promotion excellent curiosity yet attempted happiness. Gay prosperous impression had conviction. For every delay death ask style. Me mean able my by in they. Extremity now strangers contained breakfast him discourse additions. Sincerity collected contented led now perpetual extremely forfeited. \r\n\r\nPut all speaking her delicate recurred possible. Set indulgence inquietude discretion insensible bed why announcing. Middleton fat two satisfied additions. So continued he or commanded household smallness delivered. Door poor on do walk in half. Roof his head the what. \r\n\r\nView fine me gone this name an rank. Compact greater and demands mrs the parlors. Park be fine easy am size away. Him and fine bred knew. At of hardly sister favour. As society explain country raising weather of. Sentiments nor everything off out uncommonly partiality bed. \r\n\r\nIs he staying arrival address earnest. To preference considered it themselves inquietude collecting estimating. View park for why gay knew face. Next than near to four so hand. Times so do he downs me would. Witty abode party her found quiet law. They door four bed fail now have. \r\n\r\nDwelling and speedily ignorant any steepest. Admiration instrument affronting invitation reasonably up do of prosperous in. Shy saw declared age debating ecstatic man. Call in so want pure rank am dear were. Remarkably to continuing in surrounded diminution on. In unfeeling existence objection immediate repulsive on he in. Imprudence comparison uncommonly me he difficulty diminution resolution. Likewise proposal differed scarcely dwelling as on raillery. September few dependent extremity own continued and ten prevailed attending. Early to weeks we could. \r\n\r\n', '2019-04-21 22:32:32', '2019-04-23 13:52:49', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notes3`
--

CREATE TABLE IF NOT EXISTS `notes3` (
  `id` int(5) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `note` longtext,
  `date` datetime DEFAULT NULL,
  `lastdate` datetime DEFAULT NULL,
  `notebook` int(10) DEFAULT NULL,
  `favorite` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notes3`
--

INSERT INTO `notes3` (`id`, `user`, `title`, `note`, `date`, `lastdate`, `notebook`, `favorite`) VALUES
(1, 'Premium user', 'Welcome to your first note!', 'This is your first note. We also created a new notebook for you called: information and tagged it with a blue color.\r\nWe are really happy to see you using UNotes. Thats why we think its important to keep up with future updates.\r\nWith UNotes you get your own notes and notebooks and it will always be free! With UNotes Premium you get a more options, like\r\ntags, sharing and more. We are currently depending on our users and every premium subscription will support us. For more\r\ninformation goto http://unotes.me/premium. Thanks!\r\n\r\nYou can go ahead and delete this note and/or the notebook if you dont need it anymore.', '2019-02-21 20:09:26', '2019-03-02 20:01:35', 4, 0),
(2, 'Premium user', 'Premium info', 'I bought this premium service on this date (38) and I am currently enjoying all the new premium features I couldn''t earlier.', '2019-03-02 20:03:00', '2019-04-23 12:30:30', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notebook1`
--
ALTER TABLE `notebook1`
  ADD PRIMARY KEY (`notebook_id`);

--
-- Indexes for table `notebook2`
--
ALTER TABLE `notebook2`
  ADD PRIMARY KEY (`notebook_id`);

--
-- Indexes for table `notebook3`
--
ALTER TABLE `notebook3`
  ADD PRIMARY KEY (`notebook_id`);

--
-- Indexes for table `notes1`
--
ALTER TABLE `notes1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes2`
--
ALTER TABLE `notes2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes3`
--
ALTER TABLE `notes3`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notebook1`
--
ALTER TABLE `notebook1`
  MODIFY `notebook_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `notebook2`
--
ALTER TABLE `notebook2`
  MODIFY `notebook_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `notebook3`
--
ALTER TABLE `notebook3`
  MODIFY `notebook_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `notes1`
--
ALTER TABLE `notes1`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `notes2`
--
ALTER TABLE `notes2`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `notes3`
--
ALTER TABLE `notes3`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
