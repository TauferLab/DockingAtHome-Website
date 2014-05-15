<?php

function display_target_link($target) {
	return "<a href=\"/images/targets/".$target.".gif\" class=\"thickbox\" title=\"Target ".$target."\">".$target."</a>";
}

$project_news = array(
array(
  'date' => "Oct 17, 2011 14:00 EST",
  'title' =>"Docking@Home Survey",
  'text' => "We would like to know your opinion about Docking@Home. Please complete <a href='https://delaware.qualtrics.com/SE/?SID=SV_etFWFIiMLEMsPli'>this short survey</a>. Thanks!" ),
array(
  'date' => "Oct 2, 2011 9:48 EST",
  'title' =>"HIV Cross-docking almost completed",
  'text' => "The cross-docking simulations of our set of HIV complexes is almost done. This will allow us to start the statical analysis of
the data collected with your help while starting a new set of cross-docking for a new protein, the trypsin." ),
array(
  'date' => "Aug 26, 2011 9:48 EST",
  'title' =>"Irene is moving towards Delaware",
  'text' => "The university has issued a weather alert and warned all that if Irene hits Delaware we may have power outages. The D@H server and webpage may be down during the weekend. Let's cross the fingers that Irene will not visit us. If you are on the East Coast, stay home safe!" ), 
array(
  'date' => "Jul 14, 2011 15:34 EST",
  'title' =>"A new paper on D@H",
  'text' => "While working with D@H we are also looking for new ways to use your resources efficiently to get quality of science. This <a href='http://gcl.cis.udel.edu/publications/conferences/011HPCC/paper.pdf'>paper</a> summarizes one of our efforts. " ), 
array(
  'date' => "May 30, 2011 22:39 EST",
  'title' =>"A new idea for D@H",
  'text' => "We started a new project component of Docking@Home that aims to involve you in the definition of Docking@Home job and in helping us in discovering new science. Read more about the new D@H idea in this <a href='http://gcl.cis.udel.edu/data/ExSciTechposter.pdf'>poster</a>. " ), 
array(
  'date' => "May 10, 2011 13:41 EST",
  'title' =>"Issues with D@H server fixed",
  'text' => "We recovered the D@H server and the water leak in the server room has been fixed!" ), 
array(
  'date' => "March 29, 2011 8:48 EST",
  'title' =>"Want to read more about D@H results?",
  'text' => "Downland this <a href='http://gcl.cis.udel.edu/publications/conferences/010ACMBCB/10acmbcb_testrada.pdf'>paper</a> to read more about results you help us to achieve with D@H. Thanks!"
),
array(
  'date' => "May 3, 2011 13:41 EST",
  'title' =>"D@H server still with issues",
  'text' => "We are still working on the server and recovering it to the status before the water leak in the server room. We may have some job with errors. We are monitoring the project and working on the related issues!" ), 
array(
  'date' => "May 2, 2011 16:33 EST",
  'title' =>"Work on D@H server",
  'text' => "We are doing some maintenance work on the server and thus we will not generate, distribute, and collect results for the next 2 hours. We will keep you posted when the server is back to normal. Thanks for your patience!" ), 
array(
  'date' => "May 2, 2011 16:33 EST",
  'title' =>"Work on D@H server",
  'text' => "We are doing some maintenance work on the server and thus we will not generate, distribute, and collect results for the next 2 hours. We will keep you posted when the server is back to normal. Thanks for your patience!" ), 
array(
  'date' => "April 25, 2011 16:58 EST",
  'title' =>"AC unit failed = server down",
  'text' => "One of the AC units in the machine room suddenly failed last night. Several servers, including Docking@Home, were down for several hours. The AC unit has been patched and we are now restarting Docking@Home. What a day!" ), 
array(
  'date' => "February 7, 2011 9:45 EST",
  'title' =>"Abort 0% progress",
  'text' => "Due to the problem with the space in D@H some workunits were sent with an incomplete input file and are not progressing. Please abort workunits with 0% progress. We are so sorry for the inconvenience!!"
),
array(
  'date' => "February 5, 2011 2:43 EST",
  'title' =>"D@H in recovery mode",
  'text' => "We are now generating new jobs but in small batches, we need to monitor D@H for some more days and then we will resume the normal generation rate. Thanks for your patience"
),
array(
  'date' => "February 5, 2011 9:00 EST",
  'title' =>"D@H in recovery mode",
  'text' => "We are collecting and validating results but we are not
generating and distributing new jobs for the moment, while we are
investigating what caused the problem yesterday. Please bear with us!"
  ),
array(
  'date' => "February 4, 2011 11:55 EST",
  'title' =>"Disk problems",
  'text' => "We have been experiencing problems with the disk on which
we have the download partition of D@H. We stopped the generation and
distribution of jobs while we are working on the issue. We are
still collecting and validating results. We will keep you posted..."
  ),
array(
  'date' => "November 12, 2010 4:43 EST",
  'title' => "Serious issue with workunits generation",
  'text' => "We are recovering from the earlier problem, but we need to keep generation of new work low during this weekend. So, you may experience work starvation for a while. Thank you for your patience!!"
  ),
array(
  'date' => "November 12, 2010 4:03 EST",
  'title' => "Serious issue with workunits generation",
  'text' => "Today we had a serious problem at the server's room, docking was unplugged and the daemons were not restarted properly, Docking started generating a batch of bad workunits that were finishing too quickly (specifically they start with 1ajv1dif), Now we are working on bringing back the normal generation of work, and removing the bad workunits. We are so sorry for the inconveniences that you are experiencing!!"
  ),
array(
  'date' => "October 29, 2010 2:11 EST",
  'title' => "Maintenance work in server room",
  'text' => "During the first 2 weeks of November, there will be renovations in the server room where D@H is located, therefore we might experience some discontinuity in the job's production and validation. We will try to keep you informed before any major time down. Thanks for your patience!!"
  ),
array(
  'date' => "October 13, 2010 4:09 EST",
  'title' => "Best ligand structures displayed",
  'text' => "Now our feature showcasing the best ligand conformations per complex is operational again!! You can see the most recent best results from <a href='http://docking.cis.udel.edu/community/bestresults.php?model=mod0014crossdockinghiv1#'>here</a>. Comunity->Best Results"
  ),
array(
  'date' => "August 21, 2010 4:29 EST",
  'title' => "Maintenance work in server room (II)",
  'text' => "D@H may be down today from 6:45AM (ET) to 9AM (ET) because of maintenance work in the server room. We will keep you posted."
  ),
array(
  'date' => "August 20, 2010 12:39 EST",
  'title' => "Problems with Shared Memory",
  'text' => "We are experiencing problems with the shared memory and thus workunits may not be available for your client. We are working on this and will keep you posted. Thank you for your patience."
  ),
array(
  'date' => "August 20, 2010 3:25 EST",
  'title' => "Maintenance work in server room",
  'text' => "We have currently some maintenance work in the server room at UD and this may impact our D@H server. Thank you for your patience."
  ),
array(
  'date' => "June 29, 2010 21:39 EST",
  'title' => "Length of cross-docking workunits",
  'text' => "The current workunits are cross-docking ligands with different protein conformations. Each workunit should last between 4 and 6 hours."
  ),
array(
  'date' => "April 14, 2010 15:49 EST",
  'title' => "Power outage",
  'text' => "Today we had a power outage on the servers room, therefore D@H was down for a number of hours in the morning. We are up and distributing again!"
  ),
array(
  'date' => "March 29, 2010 11:57 EST",
  'title' => "D@H resume distribution",
  'text' => "After a hard period of adjustments and instability due to earlier storage problems and its consequences, D@H finally resumes normal distribution. Thank you for your patience."
  ),
array(
  'date' => "March 26, 2010 15:09 EST",
  'title' => "Workunits with 0% progress",
  'text' => "Dear volunteers, it has come to our attention (thanks to several of you) that there are still many workunits out there with 0% progress. The most likely explanation is that they are old workunits created during the period in which we had the storage pressure (March 7th) and therefore their input files were sent empty or incomplete, if you still have one or more of those old workunits, please abort them (or just reset the project). The problem wont be back since we almost doubled the space of D@H. Sorry for the inconvenience, and thank you for staying with us. Newer workunits should have in their name the word: crossdocking."
  ),
array(
  'date' => "March 11, 2010 9:23 EST",
  'title' => "D@H down for maintenance",
  'text' => "At 9:30 today we will shut down D@H because we are doing some adjustments in the storage partition. The work won't last more than 1 hour, so we will resume normal operations very soon. Thank you"
  ),
array(
  'date' => "March 10, 2010 15:11 EST",
  'title' => "D@H down for maintenance",
  'text' => "In the past few days we had problems with incomplete workunit inputs due to storage shortage in D@H. Tomorrow morning (March 11) we will expand our data partitions but we need to unmount the project temporarily (no more than 1 hour). We will keep you posted"
  ),
array(
  'date' => "March 9, 2010 12:29 EST",
  'title' => "D@H resumes distribution",
  'text' => "Docking@Home is slowly back to normal. Due to storage shortage we will distribute a slightly lower amount of workunits but all the daemons are back"
  ),
array(
  'date' => "March 7, 2010 17:20 EST",
  'title' => "D@H temporarily suspends work generation",
  'text' => "Docking@Home will interrupt the distribution of new workunits until the storage pressure is released. This means that tomorrow (March 08), or the day after tomorrow at most (March 09) we will resume with the normal distribution activity. Thank you for your patience!!"
  ),
array(
  'date' => "March 7, 2010 9:49 EST",
  'title' => "D@H temporarily suspends work generation",
  'text' => "We temporarily suspended the generation of new jobs while investigating some issues with the charmm script. Stay tuned .."
  ),
array(
  'date' => "February 2, 2010 16:18 EST",
  'title' => "D@H starts crossdocking",
  'text' => "This week Docking@Home starts its crossdocking phase, we will perform docking of a given ligand with slightly different conformations of the receptor, then our postprocessing algorithm will select the best ligand conformation. This process simulates the flexibility of the protein resulting in more realistic simulations"
  ),
array(
  'date' => "February 1, 2010 19:05 EST",
  'title' => "New experiments starting tomorrow",
  'text' => "Tomorrow D@H will start crossdocking, it is a critical change but we expect we will move smoothly. Please be patient in the event of possible crashes"
  ),
array(
  'date' => "January 1, 2010 11:45 EST",
  'title' => "Happy New Year",
  'text' => "This year has been exciting, we are in the last phase of testing our docking algorithms, we have now complete results for HIV1 and Trypsin, we are running p38alpha and after that we will start a crossdocking phase. Thank you to all our volunteers and happy New Year"
  ),
array(
  'date' => "November, 2009 19:26 EST",
  'title' => "Preliminary results for HIV1 phases I, II, and III",
  'text' => "Our <b><a href='http://docking.cis.udel.edu/about/science/results.php'>preliminary results for HIV1</a></b> complexes from the 3 phases of D@H show that our algorithms are accurate and robust. If this behavior holds for the remaining tests (Trypsin and P38alpha) Docking@Home will be ready to start cross-docking new structures. Special thanks to all our volunteers, we woudn't be at this point without you."
  ),
array(
  'date' => "October 19, 2009 18:07 EST",
  'title' => "D@H third phase: Trypsin",
  'text' => "We are starting the distribution of trypsin complexes using initial configurations that are at least 5A away from the crystal structure. With this set of experiments we expect to prove that our preprocessing algorithm can find native-like docking structures despite the initial conditions of the docking."
  ),
array(
  'date' => "August 24, 2009 11:58 EST",
  'title' => "D@H third phase",
  'text' => "Since we started testing HIV1 we expect that the workunits will be shorter than our previous batch. We have also detected download errors in some machines, we are investigating if this issue has something to do with the new complexes or are more a BOINC-related issue."
  ),
array(
  'date' => "August 26, 2009 11:45 EST",
  'title' => "D@H third phase",
  'text' => "Today D@H starts its 3rd phase of validation. This time we will dock HIV1 protease, Trypsin, and P38alpha proteins using ligands with very different initial conformations than those in the crystal complexes. With these experiments we expect to prove that by combining our prostprocessing with our sampling capabilities, D@H is able to find near-native structures even if the initial conditions are not favorable."
  ),
array(
  'date' => "August 24, 2009 12:46 EST",
  'title' => "D@H in Chemical & Engineering News",
  'text' => "<a href='http://pubs.acs.org/cen/newscripts/87/8734newscripts.html?featured=1'> Here you can read an article </a> of Daniella Jaeger for Chemical & Engineering News featuring inhalable chocolate and Docking@Home."
  ),
array(
  'date' => "August 05, 2009 13:02 EST",
  'title' => "New executable",
  'text' => "Today we are distributing a new executable. We recompiled our application with standarized flags so that Windows and Linux machines take about the same time to compute workunits; also several bugs in the graphical application have been fixed. If you encounter any problems (usually download errors) please update or reset the project in the BOINC client."
  ),
array(
  'date' => "August 03, 2009 10:04 EST",
  'title' => "Fixed credits in D@H",
  'text' => "In view of your many requests, Docking@Home is now using fixed credits. We are using a dynamic adjustment of credit that updates the flops estimation of the workunits every 3 hours. We also expect some minor problems related to the non-deterministic size of our workunits. For more information you can take a look at <a href='http://docking.cis.udel.edu/about/project/credit.php'>this page</a>."
  ),
array(
  'date' => "July 16, 2009 10:30 EST",
  'title' => "Do Good While Multitasking",
  'text' => "Today Docking@Home is on the cover of VIVmag, you can look at their web site <a href='http://vivmag.com/'>here</a>, or at the full article <a href='http://vivmag.com/vivsays/dockinghome-do-good-while-multitasking/'>here</a>."
  ),
/*array(
  'date' => "July 13, 2009 10:09 EST",
  'title' => "Account creation open again",
  'text' => "The update of Docking@Home software and database is completed. More about the updates will follow soon."
  ),
array(
  'date' => "July 12, 2009 11:00 EST",
  'title' => "Account creation temporarily stopped",
  'text' => "We have temporarily disable account creation for updating of Docking@Home software and database"
  ),*/
array(
  'date' => "June 26, 2009 18:17 EST",
  'title' => "D@H in Scientific American",
  'text' => "Docking@Home is in Scientific American!! Check the <a href=' http://www.scientificamerican.com/blog/60-second-science/post.cfm?id=help-wanted-a-new-project-for-your-2009-06-22'> link at the 60-Second Science Blog</a>"
  ),
array(
  'date' => "June 04, 2009 10:16 EST",
  'title' => "P38alpha distribution",
  'text' => "Today we will resume our normal distribution rate with p38alpha ".display_target_link("1a9u")." Results of the preliminary tests we did yesterday with some D@H workunits indicate that a normal execution of this complex can take from 4 to 13 hours."
  ),
array(
  'date' => "June 03, 2009 11:48 EST",
  'title' => "Change of protein and low distribution",
  'text' => "Today we will start distributing our simulations with p38alpha and model 14. Since the change of protein may cause workunits with errors, today we will keep a very low distribution and we will increase it gradually. If we have not found any problem by tomorrow afternoon we will resume our normal distribution rate. Workunits of the first complex (1a9u) take in average from 4 to 6 hours to complete"
  ),
array(
  'date' => "May 24, 2009 10:48 EST",
  'title' => "Power outage in Newark, DE",
  'text' => "Yesterday there was a power outage that affected most of Newark. That was the cause for our servers to be out of service. Now they are back and all D@H daemons are working normally."
  ),
array(
  'date' => "May 2, 2009 14:46 EST",
  'title' => "D@H screensavercode available in Google Code",
  'text' => "The D@H screensaver source is now availabe in Google Code. Download the code <a href=\"http://code.google.com/p/docking-at-home-screensaver/\">here</a>."
  ),
array(
  'date' => "May 1, 2009 11:24 EST",
  'title' => "Important: Abort 1hpv",
  'text' => "The problem with 1hpv is not isolated and will affect ALL 1hpv workunits, the input file 1hpv_mod0014_* was sent corrupted and it is preventing the execution of workunits. We already cancelled these workunits at the server, but you also need to abort them from the clients. Thank you for your patience."
  ),
array(
  'date' => "May 1, 2009 9:04 EST",
  'title' => "Job distribution temporary suspended",
  'text' => "We had a problem with the complex 1hpv that seems to time out. We temporarily suspended the generation of jobs for a couple of hours. Credits and results collection are working. Stay tuned for more information."
  ),
array(
  'date' => "April 27, 2009 11:10 EST",
  'title' => "Complexes of the week",
  'text' => "This week we are running simulations with the following complexes: ".display_target_link("1hps").", ".display_target_link("1hpv").",".display_target_link("1hpx")." and ".display_target_link("1hsg").""
  ),
array(
  'date' => "April 20, 2009 11:15 EST",
  'title' => "Complexes of the week",
  'text' => "This week we are running simulations with the following complexes: ".display_target_link("1gno").", ".display_target_link("1hbv").",".display_target_link("1hih")." and ".display_target_link("1hps").""
  ),
array(
  'date' => "April 08, 2009 12:20 EST",
  'title' => "Complexes of the week",
  'text' => "This week we are running simulations with these complexes: ".display_target_link("1ebw").", ".display_target_link("1ebz").",".display_target_link("1ec1")." and ".display_target_link("1g2k").""
  ),
array(
  'date' => "April 4, 2009 10:50 EST",
  'title' => "Complexes of the week",
  'text' => "This week we are running simulations with these complexes: ".display_target_link("1d4i").", ".display_target_link("1d4j").", and ".display_target_link("1dif").""
  ),
array(
  'date' => "March 18, 2009 11:51 EST",
  'title' => "New docking model (II)",
  'text' => "Today we start testing model 14. This week we will run: ".display_target_link("1hvi").", ".display_target_link("1hvj").", ".display_target_link("1ajv").", and ".display_target_link("1ajx").". The workunits are longer than workunits in model 13. For more information <a href=\"http://docking.cis.udel.edu/community/forum/thread.php?id=411\">go to the forum</a>"
  ),
array(
  'date' => "March 13, 2009 18:42 EST",
  'title' => "New docking model",
  'text' => "We are ready to distribute new computation with a new, more accurate model of the docking process. More about the new model can be found <a href=\"http://docking.cis.udel.edu/community/forum/thread.php?id=411\">in the forum</a>."
  ),
array(
  'date' => "March 11, 2009 10:42 EST",
  'title' => "New work-untis (III)",
  'text' => "This week we will test the last batch of trypsin. We will test: ".display_target_link("1pph").", ".display_target_link("1qb6").", ".display_target_link("1qb9").", and ".display_target_link("1tpp").". After that we will start whith a new model."
  ),
array(
  'date' => "March 04, 2009 10:56 EST",
  'title' => "Work on server completed successfully",
  'text' => "We have a larger download partition now and this should allow us a larger generation of jobs and less starvation (recently experienced)."
  ),
array(
  'date' => "March 03, 2009 2:36 EST",
  'title' => "Work on the server",
  'text' => "To extend the download partition, we have to stop the generation of work-units and the assignment of credits for approx. 1 hour tomorrow March 4. The work will be done at 10AM (EST). We will keep you posted!"
  ),
array(
  'date' => "March 02, 2009 8:36 EST",
  'title' => "New work-units (II)",
  'text' => "This week we will test: ".display_target_link("1k1i").", ".display_target_link("1k1j").", ".display_target_link("1k1l").", and ".display_target_link("1k1m").". The workunits should take from 0.5 to 3 hrs"
  ),
array(
  'date' => "February 23, 2009 11:42 EST",
  'title' => "New work-untis (I)",
  'text' => "This week we will keep testing trypsin. We will test: ".display_target_link("1g36").", ".display_target_link("1ghz").", ".display_target_link("1gi1").", and ".display_target_link("1gi4").". The workunits should take from 0.5 to 3 hrs"
  ),
array(
  'date' => "February 17, 2009 10:26 EST",
  'title' => "",
  'text' => "This week we will resume some short tests with trypsin. We will test: ".display_target_link("1c1r").", ".display_target_link("1c2d").", ".display_target_link("1c5t").", and ".display_target_link("1ce5").". The model has been changed and the workunits should be more stable"
  ),
array(
  'date' => "February 12, 2009 15:00 EST",
  'title' => "Server relocation",
  'text' => "Febraury 19uh and 20Tu Docking@Home will shutdown for relocation of the server. All the daemons will be stopped. Thank you "
  ),
array(
  'date' => "February 12, 2009 14:58 EST",
  'title' => "Stopping work generation for 24 hrs",
  'text' => "We are generating work again "
  ),
array(
  'date' => "February 11, 2009 15:13 EST",
  'title' => "",
  'text' => "Due to some issues with the storage resources we are stopping the generation of new work for 24 hours. The other daemons keep running and jobs will be validated and credit granted in the meantime. Thank you "
  ),
array(
  'date' => "February 10, 2009 15:21 EST",
  'title' => "Complexes for this week",
  'text' => "This week we will distribute complexes: ".display_target_link("1w83").", ".display_target_link("1w84").", ".display_target_link("1yqj").", and ".display_target_link("1a9u").". All of these complexes are stable and will take from 1 to 4 hours per job. "
  ),
array(
  'date' => "February 1, 2009 21:02 UTC",
  'title' => "D@H Newsletter Kr. 3",
  'text' => "The Docking@Home team is pleased to release the <a href='http://docking.cis.udel.edu/about/project/newsletters/newsletter_nr3.pdf'>third Docking@Home newsletter </a>to our volunteers. Enjoy the reading!"
  ),
array(
  'date' => "January 28, 2009 11:21 EST",
  'title' => "Distributing complex 1di9",
  'text' => "Today we start distributing the ".display_target_link("1di9")." complex. This complex is also stable and will take from 1 to 4 hours per job. "
  ),
array(
  'date' => "January 25, 2009 13:21 UTC",
  'title' => "New p38 apha workunits",
  'text' => "We are distributing new jobs again and at the same time we are monitoring the server to make sure that everything is back to normal. The new complex is the 1bl6. In our tests this complex took between 3 and 4 hours per job. We will keep you posted. "
  ),
array(
  'date' => "January 23, 2009 19:15 UTC",
  'title' => "Temporary suspension of WU distribution (III)",
  'text' => "The server is slowly recovering and we expect to distribute jobs again tomorrow. You may have several jobs that are terminating with an error. Please restart the project. The new jobs tomorrow should be free from this error."
  ),
array(
  'date' => "January 22, 2009 11:30 UTC",
  'title' => "Temporary suspension of WU distribution (II)",
  'text' => "The server needs to catch up with the amount of jobs distributed. The server is collecting results and giving credits. We will resume the generation of jobs tomorrow. In the meanwhile, please reset the project for a fresh new start. Stay tuned!"
  ),
array(
  'date' => "January 22, 2009 15:02 UTC",
  'title' => "Temporary suspension",
  'text' => "The disk partition of download has some problems, we are checking the partition, and therefore we suspended the distribution of new jobs. We are still collecting results and assigning credits. Stay tuned for further news. Thank you for your patience "
  ),
array(
  'date' => "January 21, 2009 16:30 UTC",
  'title' => "New protein",
  'text' => "From 16:30 to 17:30 UTC  we wil be changing the protein. The daemons may be up and down during this time and the generation and distribution of work may be interrupted "
  ),
array(
  'date' => "January 20, 2009 17:36 UTC",
  'title' => "New protein",
  'text' => "Tomorrow, Jan 21, we will start docking a new protein. P38alpha, also known as SAPK2a and MAPK14, is involved in the regulation of cellular stress responses as well as the control of proliferation and survival of many cell types. Several promising compounds that inhibit p38 alpha are being investigated as potential therapies for arthritic and inflammatory diseases, <a href='http://www.rndsystems.com/molecule_detail.aspx?m=194'7> more info here</a>. This protein seems to be more stable than Trypsin, and we can expect longer workunits. Please also expect minor problems during the transition phase. Thank you "
  ),
array(
  'date' => "January 20, 2009 01:41 UTC",
  'title' => "Slow WUs Generator",
  'text' => "The work-unit generator seems not able to keep up the pace with your requests for jobs. We are working on this issue and we will keep you posted."
  ),
array(
  'date' => "January 14, 2009 04:45 UTC",
  'title' => "Docking@Home Attaching Issues",
  'text' => "We found and fixed the problem with the new website that was preventing the BOINC client from correctly finding the workunit scheduler. This prevented clients from attaching or getting workunits. The issue should be resolved now. If you continue to have issues, please post them in this <a href=\"http://docking.cis.udel.edu/community/forum/thread.php?id=383\">thread</a>. Thank you for your patience."
  ),
  array(
    'date' => "January 13, 2009 18:43 UTC",
    'title' => "",
    'text' => "We are having some issues with the new web page, for the moment new hosts cannot attach to the project. We will let you know when the problem is solved. Thank you."
  ),
  array(
    'date' => "January 13, 2009 04:21 UTC",
    'title' => "New Docking@Home Website!",
    'text' => "Surprise and happy new year! Welcome to the new Docking@Home website. Built by University of Delaware Interactive Media students, the new website was redesigned from the ground up to provide a better, unified experience with usability in mind. Please feel free to comment on this <a href=\"http://docking.cis.udel.edu/community/forum/thread.php?id=383\">thread</a>."
  ),
  array(
    'date' => "January 08, 2009 20:30 UTC",
    'title' => "",
    'text' => "We will upgrade the Web page next Monday January 12th and it may be down from 5 to 11 PM EST"
  ),
  array(
    'date' => "January 05, 2009 13:29 UTC",
    'title' => "",
    'text' => "There are some problems with the server. It is very slow. We are working to solve the issue. Thank you"
  ),
  array(
    'date' => "January 04, 2009 18:02 UTC",
    'title' => "",
    'text' => "The new version of the Web page is almost ready. We will have a functional prototype very soon"
  ),
  array(
    'date' => "December 01, 2008 13:15 UTC",
    'title' => "",
    'text' => "Please expect many short workunits, we are trying to distribute trypsin again, but these complexes tend to have energy violations, which result in shorter workunits. Sorry for the inconvenience"
  ),
  array(
    'date' => "November 23, 2008 18:01 UTC",
    'title' => "",
    'text' =>"Dear Volunteers, after an exciting week at SC08, Docking@Home is back and fully functional. Tomorrow Monday I'll check pending petitions and issues. Thank you all for your support and understanding during this week."
  ),
  array(
    'date' => "November 14, 2008 20:15 UTC",
    'title' => "",
    'text' => "The week of November 17 to 21 the team of Docking@Home is attending to <a href='http://sc08.supercomputing.org/'>Supercomputing 2008</a>. During that week we won't be able to take care appropriately of the server and we won't be able to address issues that may arise, therefore we will stop distribution of work from November 14 to November 23. The server and other daemons will still working. Results will be validated and credit will be granted. We won't be able answer quiestions on the forums. Thank you for your undestanding and see you soon!!."
  ),
  array(
    'date' => "November 05, 2008 18:40 UTC",
    'title' => "",
    'text' => "We have now an explanatory video of the Docking@Home screen saver on youtube. Check <a href=http://www.youtube.com/watch?v=0bcgPAV0R7s>this link</a> to see it!!"
  ),
  array(
    'date' => "November 03, 2008 13:38 UTC",
    'title' => "",
    'text' => "Due to your great support crunching about 600 000 HIV workunits, today we start a new phase of Docking@Home with the distribution of Trypsin. We did extensive testing before submiting this new protein but we may have some problems due to the new files distributed."
  ),
  array(
    'date' => "October 31, 2008 19:35 UTC",
    'title' => "",
    'text' => "The week of November 17 to 21 the team of Docking@Home is attending to <a href='http://sc08.supercomputing.org/'>Supercomputing 2008</a>. During that week we won't be able to take care appropriately of the server and we won't be able to address issues that may arise, therefore we will stop distribution of work from November 14 to November 23. Thank you for your undestanding."
  ),
	array(
      'date' => "October 11, 2008 14:00 UTC",
      'title' => "",
      'text' => "We are experiencing some problems with the system. We are making frequent starts and stops until we have found what is the problem."
    ),
    array(
      'date' => "October 08, 2008 16:59 UTC",
      'title' =>"",
      'text' => "Today we are doing migration of databases, although the server will be up it might be a little unstable"
    ),
    array(
      'date' => "October 01, 2008 15:30 UTC",
      'title' =>"",
      'text' => "We had a great response of users filling the survey. Thank you all for your commitment with the project!!"
    ),
    array(
      'date' => "September 25, 2008 17:48 UTC",
      'title' =>"",
      'text' => "Please, help us to improve our Web site by filling an online survey, for more information check <a href='http://docking.cis.udel.edu/community/forum/thread.php?id=343'>this thread</a> in the forum. Thank you!"
    ),
    array(
      'date' => "September 22, 2008 19:31 UTC",
      'title' =>"",
      'text' => "Dear Volunteers: please check your recent assigned workunits, if you have workunits that have been running for more than 1hr and still have zero progress, please abort them. They were originated by the error on our download partition. We are sorry for the inconvenient"
    ),
    array(
      'date' => "September 21, 2008 23:48 UTC",
      'title' =>"",
      'text' => "You may experience some download errors due to old work-units that were generated in the interval of time we had issues with the download partition today. The system is recovering and we are monitoring it. Thanks for your patience!"
    ),
    array(
      'date' => "September 21, 2008 22:13:00 UTC",
      'title' =>"",
      'text' => "The issues with the downlad partition are under control now. We are distribution new work-units and addressing new challenges. Stay tuned!"
    ),
    array(
      'date' => "September 21, 2008 19:22:00 UTC",
      'title' =>"",
      'text' => "Some issues with the download partion on the server is prevening us from distributing work-units. We are working on this."
    ),
    array(
      'date' => "September 10, 2008 21:25:00 UTC",
      'title' =>"",
      'text' => "Docking@Home is back. Now we are distrbuting model 13sc. This model keeps track of the ligand structure, enabling the study of initial conditions in our simulations. We started with complex 1HVI: the Hiv-1 protease complexed with the inhibitor A77003"
    ),
    array(
      'date' => "September 10, 2008 15:17:00 UTC",
      'title' =>"",
      'text' => "Today Docking@Home will be down for several hours starting at 19:00 UTC. We will do some maintenance to the database and we will start distributing a new model. News about this model will follow"
    ),
    array(
      'date' => "September 08, 2008 16:31:00 UTC",
      'title' =>"",
      'text' => "Docking@Home opens the creation of new accounts. Please go to the forum for discussions about the stability of the project: <a href='http://docking.cis.udel.edu/community/forum/thread.php?id=323'>Moving to Beta</a>"
    ),
    array(
      'date' => "September 05, 2008 15:25:00 UTC",
      'title' =>"",
      'text' => "Docking@Home will open the creation of accounts on September 08"
    ),
    array(
      'date' => "September 04, 2008 14:00:00 UTC",
      'title' =>"",
      'text' => "We had an enthusiastic participation of new users joining Docking@Home. Now we have 342 new users, thank you and welcome to D@H!! "
    ),
    array(
      'date' => "September 02, 2008 16:06:00 UTC",
      'title' =>"",
      'text' => "Tomorrow September 03, Docking@Home will be open 24hrs for creation of new accounts, starting at 14:00 UTC "
    ),
    array(
      'date' => "September 01, 2008 08:50:00 UTC",
      'title' =>"",
      'text' => "We are distributing a new complex: 1ajx. HIV-1 protease in complex with the cyclic urea inhibitor AHA001 "
    ),
    array(
      'date' => "August 21, 2008 1:51:00 UTC",
      'title' =>"",
      'text' => "Take a close look at our targets by scrolling to the bottom of this page and clicking on the target icons!"
    ),
    array(
      'date' => "August 20, 2008 12:33:00 UTC",
      'title' =>"",
      'text' => "We are distributing a new complex: 1ajv."
    ),
    array(
      'date' => "August 13, 2008 20:20:00 UTC",
      'title' =>"",
      'text' => "We are distributing a new complex: 1hvj. We use the same protein but different tentative drug (ligand)"
    ),
    array(
      'date' => "August 12, 2008 15:21:00 UTC",
      'title' =>"",
	    'text' => "New public keys!!! Please detach and reattach to D@H. Thanks"
    ),
    array(
      'date' => "August 12, 2008 14:15:00 UTC",
      'title' =>"",
	    'text' => "D@H will be down for 2 hours today from 13:00 UTC for some upgrades of the charmm applicaiton and the server"
    ),
    array(
      'date' => "August 8, 2008 10:15:00 UTC",
      'title' =>"",
	    'text' => "Old work-units with id lower than 6500 were generating error -177. We canceled the old work-units. Feel free to abort any work-unit with id lower than 6500 if still crunching on your machines. Your already assigned credits are safe! "
    ),
    array(
      'date' => "August 1, 2008 7:45:00 UTC",
      'title' =>"",
	    'text' => "We are generating 1hvi work-units and crunching them with charmm34 6.07. "
    ),
    array(
      'date' => "July 31, 2008 6:30:00 UTC",
      'title' =>"",
	"We are ready to distribute the new charmm application. More about the application is in the forum."
    ),
    array(
      'date' => "July 30, 2008 4:30:00 UTC",
      'title' =>"",
	    'text' => "The server will be down for ~30 minutes today at 5:00."
    ),
    array(
      'date' => "July 29, 2008 3:30:00 UTC",
      'title' =>"",
	    'text' => "We have some problems with the newly updated server and therefore we will stop the daemons until we have fixed the server issues. We will keep you posted."
    ),
    array(
      'date' => "July 28, 2008 7:00:00 UTC",
      'title' =>"",
	    'text' => "We are distributing short Linux work-units (~1hour). Each work-unit has a variable duration, depending on the level of energies produced in the MD simulation (this is unfortunately non-deterministic). The Windows executable will follow soon."
    ),
    array(
      'date' => "July 28, 2008 3:30:00 UTC",
      'title' =>"",
	    'text' => "We are doing some work on the server. Therefore D@H may be down during the day. We will keep you posted!"
    ),
    array(
      'date' => "July 21, 2008 18:00:00",
      'title' =>"",
	    'text' => "On Wed July 23 we will update software on our server and therefore the project will be down for the whole day. We will keep you posted!"
    ),
    array(
      'date' => "June 30, 2008 14:54:00",
      'title' =>"",
	    'text' => "We distributed 300 workunits with revised FLOPS count. Please give us your feedback in the forums. Happy crunching !"
    ),
    array(
      'date' => "June 27, 2008 18:54:00",
      'title' =>"",
	    'text' => "On Monday June 30 we will have some maintenance work on our docking server. The server may be down for (hopefully) a short period. (MT) "
    ),
    array(
      'date' => "June 26, 2008 19:30:00",
      'title' =>"",
	"We distributed 300 more workunits. The deadlines for the workunits have been increased. Please give us your feedback in the forums. Happy crunching !"
    ),
    array(
      'date' => "June 25, 2008 19:46:00",
      'title' =>"",
	    'text' => "We distributed 300 more workunits. After checkpointing the CPU time should start from the time before the task was suspended. We are working on updating the Charmm executable for Intel Mac machines, we are not distributing for Macs right now. Please give us your feedback in the forums. Happy crunching !"
    ),
    array(
      'date' => "June 24, 2008 17:35:00",
      'title' =>"",
	    'text' => "We distributed 300 more workunits. Please give us your feedback in the forums. Happy crunching !"
    ),
    array(
      'date' => "June 22, 2008 22:29:00",
      'title' =>"",
	    'text' => "We distributed 300 workunits. Please give us your feedback in the forums. We are testing the new checkpointing algorithm. Happy crunching !"
    ),
    array(
      'date' => "June 20, 2008 00:38:00",
      'title' =>"",
	    'text' => "We have identified the issues regarding checkpointing and fixed the problems and are testing it. We expect to distribute workunits on docking soon."
    ),
    array(
      'date' => "June 16, 2008 19:36:00",
      'title' =>"",
	    'text' => "We ran into problems with the workunits over the weekend because of underestimated FLOPS count. We are working on accurately measuring the FLOPS count for each complex. Also we want to automate the process of workunit generation. We should have both these done soon and use them in distributing workunits on docking. "
    ),
    array(
      'date' => "June 13, 2008 19:37:00",
      'title' =>"",
	    'text' => "We are testing a new algorithm for checkpointing on docking, please run docking with few other projects and give us your feedback. Thanks for your patience. We will be distributing 300 workunits."
    ),
    array(
      'date' => "June 12, 2008 17:20:00",
      'title' =>"",
	    'text' => "The server room is still undergoing some air conditioning repairs and we are still performing tests. Hopefully we will be distributing workunits soon."
    ),
    array(
      'date' => "June 11, 2008 17:04:00",
      'title' =>"",
	    'text' => "Further work is scheduled in the server room to repair the air conditioning system in the next 24 hours. We may have the server temporarily turned off if the temperature is too high. (MT)"
    ),
    array(
      'date' => "June 9, 2008 12:14:00",
      'title' =>"",
	    'text' => "There was a major air condition failure on Saturday afternoon in the server room. All the servers had to be turned off unexpectedly. Docking is back today but the situation in the server room is still critical. We hope we will not have to turn the server down again. We will keep you posted. (MT)"
    ),
    array(
      'date' => "June 7, 2008 18:19:00",
      'title' =>"",
	    'text' => "Yesterday evening we distributed 500 WUs of a new complex, the complex 1abe. The WUs may have some problems, please report any issue to us. We are still working on the ch
eckpointing but we are making rapid progresses! I hope to have great news soon for you. Thanks! (MT)"
    ),
    array(
      'date' => "June 5, 2008 23:40:00",
      'title' =>"",
	    'text' => "We have just generated 300 1tng workunits. We are still working on the checkpointing. Tomorrow we will test a new complex."
    ),
    array(
      'date' => "June 4, 2008 21:40:00",
      'title' =>"",
	    'text' => "We have updated docking and distributing workunits for testing purposes. Checkout the screensaver and give us your comments (sorry, the screensaver is for windows only now). "
    ),
    array(
      'date' => "June 4, 2008 15:30:00",
      'title' =>"",
      'text' => "We are running some tests on docktest and in the process of updating 
docking. There will be some downtime and expect to be back soon today (23:00:00 GMT). The plan is to start distributing work on docking on Friday."
    ),
    array(
      'date' => "Apr 29, 2008 8:20:00",
      'title' =>"",
	    'text' => "It was a while ago when we updated our volunteers. In the meanwhile Arun Rajendran has joined our group as a post-doc and will dedicate his time to make sure that D@H will be back for this summer. Stay tuned!"
    ),
    array(
      'date' => "Mar 2, 2008 22:30:00",
      'title' =>"",
	    'text' => "We are diligently working to get our needed HR changes into the new boinc server code (we want to make clean changes and not a fast hack). Also as you can see we are working on a nicer movie for the home page. Let us know what you think!"
    ),
    array(
      'date' => "Feb 26, 2008 16:15:00",
      'title' =>"",
	    'text' => "The test batch of workunits we send out have generally been crunched on okay, but it has come out that the HR currently in BOINC does not work for us. We wanted to see if the fine HR would be fine enough for Docking, but it turns out not to be and we need to go back to our much finer grained homegrown HR algorithm. It will take a bit of time to incorporate this into the latest BOINC source as the HR code has changed substantially. Also, we have found out that our backup system is putting quite a load on the D@H server during the night (in the US). So much in fact that the webserver doesn't get enough cycles to stay up and respond to requests. We are looking for a resolution for this. Thanks!"
    ),
    array(
      'date' => "Feb 25, 2008 16:41:00",
      'title' =>"",
	    'text' => "We have fixed the problem with horizontal scrolling on the IE browsers and the lack of the 1abe image in the target section."
    ),
    array(
      'date' => "Feb 25, 2008 14:48:00",
      'title' =>"",
	    'text' => "We are generating 1000 work-units with the 1tng target to test whether the server is working properly. Please let us know via the website forum when you find any problems. Thanks!"
    ),
    array(
      'date' => "Feb 24, 2008 04:50:00",
      'title' =>"",
	    'text' => "Hopefully most problems with the website have been resolved. Please let us know via the website forum when you find any more problems. The problems with the workunits are currently being worked on on our test server. Thanks!"
    ),
    array(
      'date' => "Feb 24, 2008 01:00:00",
      'title' =>"",
	    'text' => "There are some problems with the web-page that we are looking into. So far we have found that the FAQ and the profiles do not work. Hopefully we will have it fixed by tommorrow night."
    ),
    array(
      'date' => "Feb 24, 2008 00:30:00",
      'title' =>"",
	    'text' => "The server is back up, we hope you like the new look and feel of the web-page. Check out the cool new ligand movies at the bottom of the page. We have generated 10 WUs, please let us know if you encounter any problems processing them. Thank you for your patience."
    ),
    array(
      'date' => "Feb 23, 2008 8:20:00",
      'title' =>"",
	    'text' => "We are going to upgrade the docking server today. We will start shutting down the system in about a half hour. It should be back up by 23:00:00 GMT."
    ),
    array(
      'date' => "Feb 22, 2008 3:30:00",
      'title' =>"",
	    'text' => "To see if everything is still working as it is supposed to work, we have just generated 10 workunits (30 results) 5 minutes ago. The protein-ligand combination is the same we have been using at UTEP (1tng_mod0011), but as this is only for testing that's okay. Let us know if things look okay on your boinc clients and we keep an eye on the server. Thanks!"
    ),
    array(
      'date' => "Feb 9, 2008 2:30:00",
      'title' =>"",
      'text' => "Three new members of the GCLab are now working together to put D@H back on-line. Abel is working on the CHARMM compilation and testing; Robert is building the D@H screensaver; and Jason is working on the servers and the pool of heterogenous machines for our tests. Abel has just arrived from UTEP where he got his BS in CS last December; Robert and Jason are undergraduate students at UDel. They are doing a terrific work to have D@H ready for our volutneers soon. Keep up the good work Abel, Jason, and Robert!"
    ),
    array(
      'date' => "Jan 14, 2008 15:15:00",
      'title' =>"",
      'text' => "We suffered a severe power outage on Saturday that took long enough (4h) that even our UPS system could not keep the server up and. The system is now back up as you can see, but obviously we have to do get an automatic graceful shutdown procedure in place. This will be high on th priority list. We are currently testing the work creation procedures on our test server to make sure that all works as it should (we found a couple of small problems that we fixed). When that is done, we will start to generate work on docking again. Thanks for your patience. We realize you all have needed a lot of that the last months."
    ),
    array(
      'date' => "Dec 23, 2007 23:45:00",
      'title' =>"",
	    'text' => "Another milestone reached. As you can see from the URL in your browser, the Docking@Home website has been moved to University of Delaware! For now only the website will work, but we will be working on making sure that work is sent out soon again. So if you have not done it yet, please disconnect your boinc client from the URL http://docking.utep.edu and wait until we tell you to connect to the URL http://docking.cis.udel.edu. The old URL now has a redirect in place to bring you automatically to D@H's new home. Please make sure your bookmarks/favorites get updated. Thanks for all your patience!"
    ),
    array(
      'date' => "Nov 18, 2007 2:15:00",
      'title' =>"",
      'text' => "We have put some photos of SC'07 online. Please check them out at <a href=\"http://www.eecis.udel.edu/~taufer/gallery/07_SC/\" target=\"_blank\">http://www.eecis.udel.edu/~taufer/gallery/07_SC/</a>. As you can clearly see we had a lot of fun in Reno :-)"
    ),
    array(
      'date' => "Nov 9, 2007 2:15:00",
      'title' =>"",
      'text' => "The D@H team will be present at SC'07 next week. Michela and Trilce can both be found in the University of Delaware booth #3315. Andre can be found in or near the SGI booth #502 (since that's where he works these days). Hope to see you in Reno next week!"
    ),
    array(
      'date' => "Oct 29, 2007 3:15:00",
      'title' =>"",
      'text' => "The docking machine has arrived at the department and we will configure it in the next week. It will be behind the UDel firewall until we have tested the system and are sure that everything works as it should. Docktest, our test server should arrive in the next week as well. As you can see we are getting close..."
    ),
    array(
      'date' => "Sep 19, 2007 20:50:00",
      'title' =>"",
	    'text' => "The new servers have been ordered. We have chosen once again Penguin as our vendor and now we just hope Penguin will soon deliver the machines so that we can start installing docking.cis.udel.edu. Stay tuned!" 
    ),
    array(
      'date' => "July 14, 2007 18:15:00",
      'title' =>"",
	"The backup of the boinc related directories on the server took a lot longer than anticipated, but the forums are back up again. The boinc scheduler will stay down until after the move. Thanks everybody!" 
    ),
    array(
      'date' => "July 10, 2007 19:25:00",
      'title' =>"",
	    'text' => "This afternoon the system will be down for a while so that we can make backups of all the data. We will switch on the website as soon as we are done."
    ),
    array(
      'date' => "July 4, 2007 16:15:00",
      'title' =>"",
	    'text' => "First a happy 4th of July holiday to all US volunteers. Yesterday we have sent out a personal email to all of you asking you to de-attach from the project and after the move attach again to the new URL. All the stats will be preserved and move with us so you will start again where you finished. Thanks for all the help and happy moving to us :-)"
    ),
    array(
      'date' => "July 2, 2007 22:10:00",
      'title' =>"",
	    'text' => "We have canceled the last two results in the queue. There is 1 more result in progress that has to be returned (or time-out). Thanks to zombie67 and others for the <a href=\"http://docking.cis.udel.edu/community/forum/thread.php?id=257\">count-down</a>!"
    ),
    array(
      'date' => "July 1, 2007 1:30:00",
      'title' =>"",
	    'text' => "Almost done. There are 2 results waiting to be send out (although if nobody picks them up in the next days, we will cancel them) and we are waiting for 3 more to return (or time out). We will keep the forums open at UTEP until after the move and the setup of the new systems at Delaware, after which we will make the change to the new URL (unknown as of now). Thanks for all your help and patience!"
    ),
    array(
      'date' => "June 21, 2007 23:50:00",
      'title' =>"",
	    'text' => "The electrical problems in the UTEP server room still have not be resolved and we will have to shutdown the Docking servers again this evening. The servers will not be available from 2:00 until approx. 15:00 UTC tomorrow. Sorry again for the inconvenience."
    ),
    array(
      'date' => "June 20, 2007 21:30:00",
      'title' => "",
	    'text' => "Due to an electrical problem in the server room where the Docking servers are housed, the servers will not be available from Midnight tonight until approx. 15:00 UTC tomorrow. Sorry for the inconvenience."
    ),
    array(
      'date' => "June 19, 2007 3:40:00",
      'title' => "",
	    'text' => "We have stopped the workunit generator in anticipation of stopping the D@H system temporarily for the move to Delaware. After all the workunits left have been crunched, the BOINC daemons will be stopped, we we will keep the web site and forums up as long as possible. In the mean time the new equipment in Delaware will be ordered in the next weeks and the system transfered in July and August. When everything goes as planned we should be up and running again somewhere in September latest. When the system is available for attachment, we will write an email to all our volunteers to let them know the new URL (something with udel.edu in it) so that everybody can attach again. By that time we should also have some new app versions again to test. Thanks for your patience in this and please bear with us!"
    ),
    array(
      'date' => "June 11, 2007 21:30:00",
      'title' => "",
	    'text' => "Because the project is moving to Delaware and the fact it is summer holiday for many students, things have come to a slowdown a bit. We are still working on many things including the new Charmm version, the HIV model that will soon be released on the grid and the Windows screensaver. So bear with us for the moment and look forward for many exciting things to come! Thanks for all of your help."
    ),
    array(
      'date' => "June 4, 2007 3:40:00",
      'title' => "",
	    'text' => "We are currently testing a new protein-ligand complex. The protein is the HIV-protease (the protein in the animation in the project main webpage). We performed short simulations on Linux machines to test checkpointing and result correctness successfully. This week we will test longer simulations and keep you posted."
    ),
    array(
      'date' => "May 28, 2007 20:15:00",
      'title' => "",
	    'text' => "Docking@Home will soon be moving from UTEP to the <a href=\"http://www.cis.udel.edu\">University of Delaware (UDel)</a>. We are looking for a research associate that can help us to develop and maintain the Docking@Home system and the Charmm application. If you are interested in this position (and we hope many of you do feel the urge to work with BOINC professionally), please have a look at some more <a href=\"postdoc.php\">details</a>."
    ),
    array(
      'date' => "May 6, 2007 20:45:00",
      'title' => "",
	    'text' => "We have finally got our hands on the new charmm release c34a2 and are working to boincify and test it so that we can release it on D@H. We believe this release will solve the execution time issues we are currently experiencing with 5.07. Since Andre is not working on this 100% anymore, it might take a while to get this out, but we will get there eventually!"
    ),
    array(
      'date' => "April 29, 2007 02:45:00",
      'title' => "",
	    'text' => "We are going back to boinc credits for the moment. Allthough the running times might be a bit longer for the workunits, at least people will be appropriately credited for their cpu cycles. Linux crunchers, please make sure you are running the latest stable version of the boinc client so that your benchmarks are measured decently compared to the other platforms. Thanks!"
    ),
    array(
      'date' => "April 26, 2007 23:45:00","",
	    'text' => "The server is operational again. We have upgraded all the apps (make sure you are running charmm 5.07) and the input data for the application. Running times should be better now and the percentage of workunits that successfully validates should go up. Please let us know about your experience on the forums. As always thanks for your patience!"
    ),
    array(
      'date' => "April 26, 2007 21:30:00",
      'title' => "",
	    'text' => "We are currently upgrading the system and the scheduler is down. We'll post another news item when we are done."
    ),
    array(
      'date' => "April 26, 2007 20:00:00",
      'title' => "",
	    'text' => "We are going to cancel the remaining workunits in the system, because they are buggy and take too long to crunch. Please abort any work you are crunching right now and wait until we have released the new input files and will generate new work."
    ),
    array(
      'date' => "April 24, 2007 15:40:00",
      'title' => "",
	    'text' => "We are busy testing a new charmm input file to replace the one that is currently giving problems on Docking. Hopefully we can finalize testing this week. Thanks for your patience!"
    ),
    array(
      'date' => "April 18, 2007 20:10:00",
      'title' => "",
	    'text' => "We have found that there is a problem with the Charmm input file that is causing the extended running times. We are currently searching for a solution for this and will release new workunits at that time. For now we will suspend the creation of new workunits. Thanks for your patience."
    ),
    array(
      'date' => "April 16, 2007 22:45:00",
      'title' => "",
	    'text' => "There is a problem with increased running times of Charmm on Macs and Linux machines. We are working hard to find out what is going on and will hopefully soon find a fix for this. Thanks for all of your comments in the forum!"
    ),
    array(
      'date' => "April 16, 2007 22:15:00",
      'title' => "",
	    'text' => "We just released a new version 5.06 for linux-x86_64, because of a bug in version 5.05. Thanks to volunteer <a href=\"http://docking.cis.udel.edu/community/show_user.php?userid=293\">fubared</a> for spotting this."
    ),
    array(
      'date' => "April 11, 2007 16:00:00",
      'title' => "",
	    'text' => "We have implemented the WCG solution to compress all outgoing files to the boinc clients. This means that a lot less of your incoming bandwidth is used for the transfer of D@H applications and input files and you can start crunching faster. Thanks to Kevin Reed at WCG!"
    ),
    array(
      'date' => "April 10, 2007 22:15:00",
      'title' => "",
	    'text' => "Docking@Home is up and running again with the new app versions and a new charmm input file. Please report any problems you notice and issues you have in the forums."
    ),
    array(
      'date' => "April 10, 2007 21:15:00",
      'title' => "",
	    'text' => "The D@H scheduling server will be unavailable for the next hour, because of a major app upgrade. After the upgrade our checkpointing should be more robust and the number of writes to the charmm log file (and thus your disks) should be a lot lower. We will also add the Mac PowerPC platform for the first time."
    ),
    array(
      'date' => "April 9, 2007 23:30:00",
      'title' => "",
	    'text' => "Docking@Home will not be available from 23:30 until 00:30 today due to network maintenance by the UTEP IT department."
    ),
    array(
      'date' => "April 6, 2007 18:15:00",
      'title' => "",
	    'text' => "We have run into some segfault issues again with the Linux and Mac Intel versions of the app and are currently investigating these issues. Testing the Windows and Mac PPC versions of our new checkpointing release is going well. We need to release all 4 versions at the same time though, so we have to resolve the issues with Linux and Mac Intel before we can do this."
    ),
    array(
      'date' => "April 5, 2007 21:00:00",
      'title' => "",
	    'text' => "Attention: Tomorrow April 6 from 23:30 to April 7 00:30, Docking@Home will be unavailable due to a network switch upgrade in the server room."
    ),
    array(
      'date' => "April 4, 2007 05:40:00",
      'title' => "",
	    'text' => "One of our volunteers, Dotsch, has done a great job in help us solve the dependency problem we experienced with our Mac PPC application! This means we will release a PPC version of Charmm soon, probably together with the other apps when we deploy the checkpointing fix."
    ),
    array(
      'date' => "April 2, 2007 05:40:00",
      'title' => "",
      'text' => "On April 11-12 we will present docking@Home at NIH (the National Institute of Health) during the annual meeting of the Multi-Scale Modeling Consortium. This week we will be busy preparing the material for our presentation. We will post the presentation together with our impression when back from the meeting."
      ),
    array(
      'date' => "April 2, 2007 05:00:00",
      'title' => "",
      'text' => "Just a not to let everybody know that Windows 95/98/ME are not supported by D@H. Please do not attach these machines to the project. This is not a April 1 joke :-)"
      ),
    array(
      'date' => "March 28, 2007 03:00:00",
      'title' => "",
      'text' => "OK. Things are looking better now and full workunit generation has started (our 'you know who' mac user grabbed the first 100 :-). There seems to be a problem with the shared memory table on the monitoring page; we are working on this to fix it. Again, please let us know of any problems."
      ),
    array(
      'date' => "March 28, 2007 02:40:00",
      'title' => "",
      'text' => "We have just noticed a problem and have to cancel the 100 workunits that we just generated (luckily we only generated 100). Please abort any work you might have received from D@H. The server will be up again in 10 minutes."
      ),
    array(
      'date' => "March 28, 2007 02:30:00",
      'title' => "",
      'text' => "The work has been finished, the scheduler is active again and we've generated 100 workunits (approx. 300 results) to see how things work out (these WUs were send out VERY quickly). We've also updated the shared memory page with some more information. The new HR algorithm for sure will have to be fine-tuned so please let us now via the <a href=\"http://docking.cis.udel.edu/community/forum/thread.php?id=206\">forum</a> if you see any problems (for example your host seems to be in the wrong class). Thanks for your patience!"
    ),
    array(
      'date' => "March 27, 2007 22:30:00",  
      'title' => "",
      'text' => "The D@H scheduler will be down for the next couple of hours to implement some Homogeneous Redundancy (HR) changes and get rid of the last 407 results in the shared memory."
      ),
    array(
      'date' => "March 26, 2007 20:30:00",
      'title' => "",
      'text' => "The remaining workunits in the <a href=\"/status/\">shared memory</a> will not go away and we are planning to cancel them (while assigning credit for crunched work at the same time). Memo is working on the analysis and implementing a solution for this."
      ),
    array(
      'date' => "March 24, 2007 23:50:00",
      'title' => "",
      'text' => "When researching why the Mac Intel queue does not become smaller, we found another issue with the shared memory page that has just been fixed. Due to the Linux boinc client reporting the Family/Model/Stepping information, we know have a LinuxPreP4 HR class and not unassigned anymore (which explains the no work message)."
      ),
    array(
      'date' => "March 22, 2007 22:50:00",
      'title' => "",
      'text' => "We have just send out the second issue of our newsletter. Hope you enjoy it as much as you did the first issue. Feedback is welcome in the Cafe Docking forum (we will create a new thread for it)."
      ),
    array(
      'date' => "March 21, 2007 00:10:00",
      'title' => "",
      'text' => "We have disabled the wuGenerator to drain the system of workunits. When all the current work has been crunched we can replace the current HR filter with a new one that has completely different codes (thus the need for draining). As soon as the changes have been made, we will enable the generator again. This means that at some point you will not be able to get work anymore. Please have patience and bear with us."
      ),
    array(
      'date' => "March 14, 2007 18:25:00",
      'title' => "",
      'text' => "A page with an overview of the server and lab hardware we are using to develop D@H on is available <a href=\"/about/science/\">here</a>."
    ),
    array(
      'date' => "March 1, 2007 18:45:00",  
      'title' => "",
      'text' => "We are currently testing new Homogeneous Redundancy algorithms, which would be much easier if everybody attached to D@H would be running the latest BOINC client (5.8.15 for Windows and Mac). The reason for this is that in these versions the client reports the Family, Model and Stepping number of AMD and Intel processors (previous version do not). This makes the amount of cpu models to filter on much less. Therefore we would like to request if you could update to this latest boinc client version. It would help us greatly in our testing. Linux users, please hold off from the update until the next release comes out that contains the Family/Model/Stepping information. Thanks!"
      ),
    array(
      'date' => "March 1, 2007 18:45:00",
      'title' => "",
      'text' => "We've temporarily implemented a fix for the excessive work queue problem: instead of distributing 1 replica per workunit per user, we now distribute 1 replica per workunit per host. This way, if you own multiple machines, you will be able to get other replicas from the queue."
      ),
    array(
      'date' => "March 1, 2007 00:15:00",
      'title' => "",
      'text' => "There is some more information available on the <a href=\"/status/\">status page</a>. We have added the distribution of active hosts attached to D@H sorted by HR class. The inbalance between available hosts and reserved work is clearly visible!"
      ),
    array(
      'date' => "February 28, 2007 22:40:00",
      'title' => "",
      'text' => "We have set the quorum needed for validation back to 2 (from 3). This will get workunits validated faster and hopefully alleviate the problem with the full work queues for Linux and Mac a little bit. This will go into effect starting workunit 30440."
      ),
    array(
      'date' => "February 28, 2007 22:00:00",
      'title' => "",
      'text' => "We have started cycling the work available in the shared memory by using the -purge_stale parameter of the feeder daemon. This means that work in the SM will be swapped out with work in the database at 2 hour intervals if it has not been distributed within that interval. This means that you will see quite large changes on the Shared Memory Distribution web page."
      ),
    array(
      'date' => "February 27, 2007 22:00:00",
      'title' => "",
      'text' => "Memo has written a script to retrieve HR information from the shared memory. This information is displayed <a href=\"/status/\">here</a>. As you can see, currently a lot of work is available for Intel Linux and Mac machines (of which we do not have that many active machines) and not so much for Windows. If any of you is willing to convert their Windows box into a dual-boot with Linux or run Linux in a virtual machine, that would greatly help us. For the credits it does not matter anymore: everybody receives the same, independent of platform or OS. Thanks!"
      ),
    array(
      'date' => "February 26, 2007 22:30:00",
      'title' => "",
      'text' => "We have released charmm 5.4 for 32-bit and 64-bit Linux. This release contains a fix for the stack problem we were experiencing on Linux. The solution is an easy (but not immediately) obvious one: we know start charmm from a shell script that first sets the stacklimit to unlimited. Thanks to David Anderson for some help on this!"
      ),
    array(
      'date' => "February 20, 2007 22:00:00",
      'title' => "",
      'text' => "We have just released Charmm for the Windows AMD64/EMT64 platform. Please be aware that this is just a copy of the 32-bit binary disguised as a 64-bit one. But it will give our volunteers who run the 64-bit boinc client a chance to run some Docking workunits as well. Thanks!"
      ),
    array(
      'date' => "February 13, 2007 16:00:00",
      'title' => "",
      'text' => "The new boinc client for linux version 5.8.11 has been released. This contains a bugfix for the stack limit problem that caused all the results crunched by the 5.8.8 client to crash. We discovered that there was some information for the processor model missing yesterday which has been fixed by the boinc devs and will be incorporated in the next client release. Please upgrade to 5.8.11 or higher if you can. This will help us a lot with the HR issue."
      ),
    array(
      'date' => "February 7, 2007 01:15:00",
      'title' => "",
      'text' => "The system is up and and we have just gone to a fixed credit system. Since there are a thousand or so workunits still left in the shared memory, it might take a while until you see fixed credit being granted. We have decided to assign 3.3E-12 credit per FLOP, which for the current test workunit means 49.5 credits (it need approx. 15000 GFLOPS to compute). Of course when we start to have a more diverse pool of workunits, the amount of credit will vary as well. Please see this as an experiment and let us know what you think. This number of credits is not set in stone yet and can be changed in the future. Thanks for your patience!"
      ),
    array(
      'date' => "February 7, 2007 00:15:00",
      'title' => "",
      'text' => "The system is down for maintenance for an hour or so. Keep an eye on the news feed to see when we are up again. Thanks!"
      ),
    array(
      'date' => "February 1, 2007 23:35:00",
      'title' => "",
      'text' => "Please do not use the new BOINC client 5.8.8 for Linux yet as it will crash Charmm on your machine. The BOINC dev team is working on a solution for this with us. Thanks!"
      ),
    array(
      'date' => "February 1, 2007 21:15:00",
      'title' => "",
      'text' => "Some of our volunteers have started to use the new 5.8.x boinc client, while others are still using the older version. This is currently giving us problems with the Homogeneous Redundancy rules since the processor identification has changed in the new version. Also, the new version is sometimes crashing Charmm on Linux. We are working to resolve both problems."
      ),
    array(
      'date' => "January 30, 2007 00:25:00",
      'title' => "",
      'text' => "We have done an initial analysis of the results that we received from the script that was send to our Mac volunteers. Details can be found <a href=\"http://docking.utep.edu/macscript_results.php\">here</a>."
    ),
    array(
      'date' => "January 30, 2007 00:15:00",  
      'title' => "",
      'text' => "The D@H server has been successfully upgraded to version 5.9.2 of BOINC. Please let us know if you find any problems."
      ),
    array(
      'date' => "January 29, 2007 17:00:00",
      'title' => "",
      'text' => "Docking@Home will be shutdown a short time this afternoon for maintenance. We are planning to upgrade the BOINC server side components to version 5.9.2."
      ),
    array(
      'date' => "January 23, 2007 18:00:00",
      'title' => "",
      'text' => "We have made an entry for the x86_64 platform in our database and copied the Linux x86 version of the app to the x86_64 version. This means that people running the 64-bit Linux boinc client will get work too. But beware that you are still running the 32-bit app, so please don't expect any speedup. If this experiment generates too many problems, we will pull it out again. Later on we will probably also release a real 64-bit version of Charmm."
      ),
    array(
      'date' => "January 18, 2007 15:45:00",
      'title' => "",
      'text' => "The UTEP IT department has problems with their network connectivity and therefore the D@H servers were not available for a while. Sorry for that and thanks for your patience!"
      ),
    array(
      'date' => "January 17, 2007 05:30:00",
      'title' => "",
      'text' => "We have implemented a separate class for our AMD K6 machines and took the Windows AMD Family 6 machines out of the PII/III group. Things should be smoother now from that side. Thanks to Alex Klietz for his extensive testing of these machines."
      ),
    array(
      'date' => "January 14, 2007 18:30:00",
      'title' => "",
      'text' => "There seems to be a small problem regarding the release of charmm 5.4 for windows. Some of the results in workunits that already had results computed with 5.3 seem to be assigned to the new versiob 5.4. Since these version have different results, most of these results are deemed invalid. According to the BOINC developers this is the normal behavior, but we'll try to find a solution for this."
      ),
    array(
      'date' => "January 3, 2007 23:30:00",
      'title' => "",
      'text' => "We have just released Charmm 5.4 for Windows. This is a first optimized compile which will hopefully make the run about twice as fast as version 5.3. If everything looks okay with this version and running times are in the same range as Linux machines, we will make fixed credits the next step to more fairness."
      ),
    array(
      'date' => "January 3, 2007 23:30:00",
      'title' => "",
      'text' => "We have pulled PII and PIII machines out of the AMD/Windows group and assigned these machines their own HR class. This should solve some of the <i>result invalid</i> problems on the Windows side. We will keep analyzing any HR issues that arise."
      ),
    array(
      'date' => "January 3, 2007 21:15:00",
      'title' => "",
      'text' => "Starting from workunit number 19724, we have made the initial random seed for the molecular dynamics algorithm the same for all workunits. What this means is that, in theory, all results returned to the server should be exactly the same for all computers. In practice we know that this will not be true because of the architectural differences between platforms. The advantage of this will be that this will give us an exact picture of the differences that will arise and thus can modify our HR algorithm accordingly."
      ),
    array(
      'date' => "January 2, 2007 18:45:00",
      'title' => "",
      'text' => "We are back after some really nice vacation days. So nows it is full steam ahead on our open issues: checkpointing, wu-flops based credit, architectural differences analysis and a first release of our screensaver. Welcome to 2007!"
      ),
    array(
      'date' => "December 31, 2006 22:10:00",
      'title' => "",
      'text' => "The Docking@Home team wishes all volunteers of the D@H project and all the other BOINC projects a happy new year and many successes (incl. credits) in 2007!! Thanks for all of your help."
      ),
    array(
      'date' => "December 19, 2006 22:10:00",
      'title' => "",
      'text' => "The first issue of the Docking@Home <a href=\"/about/project/newsletters/newsletter_nr1.pdf\">newsletter</a> is being send out as we speak. Let us know what you think of it!"
      ),
    array(
      'date' => "December 19, 2006 22:00:00",
      'title' => "",
      'text' => "The good news keeps on flowing :-) Our paper \"Moving Volunteer Computing towards Knowledge-Constructed, Dynamically-Adaptive Modeling and Scheduling\" has been accepted at the The Workshop on Large-Scale, Volatile Desktop Grids 2007 (<a href=\"http://pcgrid07.lri.fr/\" target=\"_blank\">PCGrid2007</a>) that will take place in Long Beach next year! Again congrats to the Team!"
    ),
    array(
      'date' => "December 18, 2006 02:00:00",  
      'title' => "",
      'text' => "We just heard that our paper \"SimBA: a Discrete Event Simulator for Performance Prediction of Volunteer Computing Projects\" has been accepted at the International Workshop on Principles of Advanced and Distributed Simulation 2007 (<a href=\"http://pads07.org\" target=\"_blank\">PADS2007</a>) that will take place in San Diego next year! Congrats to the Team!"
    ),
    array(
      'date' => "December 12, 2006 22:50:00",  
      'title' => "",
      'text' => "We found a bug in our resultCollector daemon code; it was not retrieving the RMSDs and ENERGYs correctly. This has been fixed. We also added options to our daemon code to preserve result files (like the BOINC file_deleter daemon does). Memo is working on a script to get some more hardware and library information from our Mac users which will hopefully give us some more insight in the differences we get on the Intel Mac platform. This script will be sent out soon to all of ou Intel Mac users; keep an eye on your inbox if you want to help us out."
      ),
    array(
      'date' => "December 5, 2006 21:10:00",
      'title' => "",
      'text' => "The BOINC community has engineered a new help system based on the Skype internet phone software. More information is available <a href=\"http://docking.utep.edu/docking_help.php\">here</a>."
    ),
    array(
      'date' => "December 5, 2006 21:10:00",  
      'title' => "",
      'text' => "The fix for the homogeneous redundancy code for Windows PII and PIII machines has been implemented. Gradually we should see the number of validated results go up for Linux and Windows machines. We are still working on the Mac Intel problem, but that one is a lot more challenging."
      ),
    array(
      'date' => "December 4, 2006 21:10:00",
      'title' => "",
      'text' => "Our project PI Michela Taufer is currently in Amsterdam to present a DAPLDS paper at the eScience 2006 conference. The paper title is <a href=\"http://www.escience-meeting.org/eScience2006/engine/schedule.php?session=M18\">\"The Effectiveness of Threshold-based Scheduling Policies\"</a>."
    ),
    array(
      'date' => "December 4, 2006 15:30:00",  
      'title' => "",
      'text' => "We have another moderator for our forums: David Ball has accepted the job and will help Suguru to watch and respond to posts on the forum. David already has been giving some great advice the last weeks/months so kudos to him!"
      ),
    array(
      'date' => "December 4, 2006 00:30:00",
      'title' => "",
      'text' => "Just to make sure that everybody understands: the PII/III fix we put in for HR is only for the Linux platform up to now. We are still testing on Windows and have to make sure this works correctly before we put it out on Docking. Sorry if the message from Nov 29 was not clear enough."
      ),
    array(
      'date' => "December 1, 2006 16:30:00",
      'title' => "",
      'text' => "We have a substantial problem with the Intel Mac version of Charmm and not many results computed are actually the same as they should be. This of course also has a consequence for the credit that is granted: many crunchers see 0 a lot of the time. If people want to, please suspend the work on your Intel Macs for now, until we have fixed this problem. Because of the available man (woman) power available this might actually be in the new year only. If people have ideas on what might be causing this, please come forward on the forums. Thanks for all of your help."
      ),
    array(
      'date' => "November 29, 2006 13:30:00",
      'title' => "",
      'text' => "Today Richard has his Master's Thesis Defense at 3 pm Mountain Time. Let's all wish him good luck!! (Drop him an email: <a href=\"http://dockweb.utep.edu/personal/richard.html\">Richard's Home Page</a>)"
    ),
    array(
      'date' => "November 29, 2006 02:50:00",  
      'title' => "",
      'text' => "We have implemented a fix in the homogeneous redundancy code that will put Linux Pentium II and III machines into the same group as the AMD machines as these are returning the same Charmm results. This should solve many of the invalid results problems in cases where these types of machines are involved. Please let us know if this is not the case. We are still experimenting with Celeron processors and the Windows platform. Thanks for your help!"
      ),
    array(
      'date' => "November 22, 2006 20:30:00",
      'title' => "",
      'text' => "The network problem at UTEP has been resolved. It actually was a problem of the ISP UTEP uses for their external network connection. Good to have you all back!"
      ),
    array(
      'date' => "November 22, 2006 14:30:00",
      'title' => "",
      'text' => "The UTEP network has a couple of problems this morning so it is well possible that you cannot reach our server for a while. We apologize for the inconvenience!"
      ),
    array(
      'date' => "November 20, 2006 18:40:00",
      'title' => "",
      'text' => "Thanks to the World Community Grid team, a fix has been implemented to make sure that the \"Work has been committed to other platforms\" message doesn't show as much as it is doing right now and the shared memory segment has been increased from 500 to 1000 to have a larger pool of replicas waiting to be distributed. Also, the website header has been decreased in (file) size a bit to accomodate our modem users better. This means we lost a little bit of quality, but gained a lot more happy volunteers :-)"
      ),
    array(
      'date' => "November 19, 2006 22:30:00",
      'title' => "",
      'text' => "The D@H team is back from a very successful week at Supercomputing 2006 and will go full steam ahead with the project again! For all the new joiners, please understand that this is a project in alpha phase and credits get lost/not assigned sometimes because of the app problems we are experiencing. Also, some Linux users current need to implement a small workaround on their machines to make crunching D@H results work. You can find it <a href=\"http://docking.cis.udel.edu/community/forum/thread.php?id=44&nowrap=true#461\">here</a>."
    ),
    array(
      'date' => "November 13, 2006 17:30:00",  
      'title' => "",
      'text' => "Our new cool website header is now online. Thanks again for the great work that Atomic Booty, Cori and Karina have accomplished: a big thank you from the D@H team and all the volunteers!"
      ),
    array(
      'date' => "November 11, 2006 03:20:00",
      'title' => "",
      'text' => "Tomorrow almost the whole Docking@Home team will be traveling to the <a href=\"http://sc06.supercomputing.org/\" target=\"_blank\">SuperComputing 2006</a> conference in Tampa, Florida. Since we have been preparing a lot for this, there was not much time to get actual work done, but Memo, who is staying behind at UTEP, will continue testing the apps we are working on."
    ),
    array(
      'date' => "November 6, 2006 17:00:00",  
      'title' => "",
      'text' => "We've made Suguruhirahara a moderator of the forum as lately some flame/hate/obscene posts have sprung up and S. offered to keep an eye. We've also made everybody an official Volunteer Tester as that's what you are helping us with! Thanks to all of our alpha testers!"
      ),
    array(
      'date' => "November 1, 2006 17:00:00",
      'title' => "",
      'text' => "The meeting with the Charmm developers and testers yesterday was good, but it seems we might have to wait a couple of days more: some of the test cases fail and therefore they need some more time to fix things up. In the meantime we will continue work on non-app related things. Thanks for your time everybody!"
      ),
    array(
      'date' => "October 25, 2006 18:20:00",
      'title' => "",
      'text' => "Docking@Home now has a cute little icon in our URL. Thanks to Cori for making this possible!"
      ),
    array(
      'date' => "October 25, 2006 00:30:00",
      'title' => "",
      'text' => "We just got news that a minor problem was detected in the new Charmm version and that we will have to wait until the fix has been retested. This can potentially take a couple of days. Thanks for all of your patience!"
      ),
    array(
      'date' => "October 24, 2006 16:50:00",
      'title' => "",
      'text' => "Here is an interesting article on <a href=\"http://www.validlab.com/goldberg/addendum.html\" target=\"_blank\">IEEE floating point arithmetic</a> that will give you an idea of the 'different results' problem we are facing with our application that is doing lots and lots of floating point calculations."
    ),
    array(
      'date' => "October 24, 2006 15:15:00",  
      'title' => "",
      'text' => "It looks like we might get the new Charmm release c33b1 today, which means we can finally get some app work done again!"
      ),
    array(
      'date' => "October 19, 2006 23:55:00",
      'title' => "",
      'text' => "We have increased the running time of our workunits slightly (added 1.5 hours on a 3 GHz P4). This will hopefully have as an effect that PCs will not come back to the server so often and request less results, thereby alleviating the HR reservation effect on the shared memory segment. In other words, you should not see the \'Work has been commited to other platforms\' so often anymore. The longer workunits will only go into effect after a while when all the current ones have been assigned."
      ),
    array(
      'date' => "October 17, 2006 15:00:00",
      'title' => "",
      'text' => "We have implemented new functionality in our workunit generator that will automatically will keep the number of unsent results in the database at a certain level (currently 500). This is a great improvement, because now we don't have to get up in the middle of the night anymore to generate work :-)"
      ),
    array(
      'date' => "October 17, 2006 15:00:00",
      'title' => "",
      'text' => "The new Charmm version has not been released yet because approval by the release manager has not been obtained yet. We expect that to be any time now. Until that time we will be working on other things on our to-do list like the automation of our work generator and the issues with the different results on PIIIs and Intel Macs. Thanks for your patience and help."
      ),
    array(
      'date' => "October 10, 2006 23:00:00",
      'title' => "",
      'text' => "We have updated our web page, consolidated the message board with the questions and answers forums, added a FAQ document and show you the current target we are working with. Let us know if you find any problems. Also Atomic's logo is the winner of the poll. Details can be found <a href=\"http://docking.cis.udel.edu/community/forum/thread.php?id=71\">here</a>."
    ),
    array(
      'date' => "October 9, 2006 22:30:00",  
      'title' => "",
      'text' => "We are waiting for a new Charmm version to be released soon (probably wednesday). Therefore we will wait with putting any new changes in the app until that version is on our system."
      ),
    array(
      'date' => "October 5, 2006 00:30:00",
      'title' => "",
      'text' => "Please vote for the logos that Cori and Atomic Booty designed for our website. The one that gets the most votes wins! The poll is <a href=\"http://docking.cis.udel.edu/community/forum/thread.php?id=71\">here</a>. We will decide by next week Tuesday October 10."
    ),
    array(
      'date' => "October 4, 2006 22:00:00",  
      'title' => "",
      'text' => "There seem to be some problems with the mac intel app in that the results that are returned from different macs (Macbook, MacMini, Macpro) are not the same (they should be). We cannot reproduce this on our macs in the lab, but are currently looking into this. This currently causes a lot of pending credits for our mac users. About 80 workunits currently seem to be have affected."
      ),
    array(
      'date' => "October 2, 2006 17:30:00",
      'title' => "",
      'text' => "We've just released 5.2 (5.02) for Mac Intel. All Mac Intel volunteers, please abort any 5.1 (5.01) work and resume with 5.2 (5.02). Thanks! Next goal: get a Mac PPC version compiled."
      ),
    array(
      'date' => "September 29, 2006 13:50:00",
      'title' => "",
      'text' => "There still seem to be some 5.1 (5.01) results floating around. Please abort all results of this type since they cause many problems during validation including pending credits. Thanks!"
      ),
    array(
      'date' => "September 18, 2006 21:50:00",
      'title' => "",
      'text' => "We are still working on the excessive writing issue. It might take a couple of days to get our checkpointing fixed and working correctly: currently checkpointing is done without looking at the user preference for disk writes."
      ),
    array(
      'date' => "September 19, 2006 15:30:00",
      'title' => "",
      'text' => "We have finally found the cause of the problem that some users were experiencing on their Linux systems. It has to do with the stacksize setting on your machine which is for some distros (SuSE 9.3 and 10 for example) set to unlimited and for others (FCx, Ubuntu, etc) set to a limited value like 10240. On the Bash and K shells your setting can be seen by typing 'ulimit -s' in a terminal. With TC shell it is 'limit'. To make the Charmm 'exit 1' errors go away, please set the stacksize to unlimited using the command 'ulimit -s unlimited'. This is not saying that Charmm will use all of your memory (it won't), but it gives us a little bit more space to do our simulations correctly and without errors. Please let us know if this does not work for you. If it does work, please add this command to your shell initialization file (.bashrc, .tcshrc, .kshrc, etc) in your home directory. Of course don't forget to resume the D@H project on your boincmgr in case you suspended it before."
      ),
    array(
      'date' => "September 18, 2006 21:50:00",
      'title' => "",
      'text' => "For all linux users: feel free to suspend the D@H project if all of your WUs error out until we've got this problem fixed. SuSE and Slackware users seem to be allright, but it looks like redhat and debian-based distros (incl. ubuntu) have a problem with our app."
      ),
    array(
      'date' => "September 18, 2006 21:50:00",
      'title' => "",
      'text' => "Still working on the Linux charmm chrash issue. Please report your distro and the fact whether all of your WUs crash it <a href=http://docking.cis.udel.edu/community/forum/thread.php?id=44>here</a>. In the meantime also some good news: thanks to Christian Beer we could fix the forum preferences (including signature) issue. In PHP5 register_long_array is Off, but for BOINC it should be On."
    ),
    array(
      'date' => "September 18, 2006 18:00:00",  
      'title' => "",
      'text' => "We've just released version 5.2 for linux and 5.3 for windows which should fix the problem where workunits that error get validated successfully. Currently working on the mac intel version, but the compiler gives me some trouble..."
      ),
    array(
      'date' => "September 18, 2006 16:00:00",
      'title' => "",
      'text' => "We're working on a fix for the linux crashing problem (challenging because not all linux users experience this) and for the excessive disk writing on all platforms (we think that's due to our checkpointing)."
      ),
    array(
      'date' => "September 16, 2006 02:30:00",
      'title' => "",
      'text' => "We've implemented a temporary fix for the file download problem. A more permanent solution will be implemented for the new workunits that we create later."
      ),
    array(
      'date' => "September 15, 2006 04:00:00",
      'title' => "",
      'text' => "We have created 500 new workunits just now. Please reset your project on the boincmgr or detach from and re-attach to the project to get rid of any old invalid wu's. Thanks!"
      ),
    array(
      'date' => "September 15, 2006 03:15:00",
      'title' => "",
      'text' => "We have just cancelled all existing workunits and will be creating new ones shortly. Please reset your project on the boincmgr or detach from and re-attach to the project. Thanks!"
      ),
    array(
      'date' => "September 15, 2006 00:30:00",
      'title' => "",
      'text' => "We are very likely to deploy the fix for the -131 error tonight (MDT). This means we are going to cancel all existing workunits and have to ask all of you to reset your project (or detach/attach). All workunits new should be around 1.5 hours as measured on a P4 3.2 GHz."
      ),
    array(
      'date' => "September 14, 2006 17:00:00",
      'title' => "",
      'text' => "Currently testing the fix for the -131 error on our test system. If it works we'll deploy on D@H. We will also reduce the result crunching time to around 1.5 hours (on a 3.2GHz P4)."
      ),
    array(
      'date' => "September 14, 2006 17:00:00",
      'title' => "",
      'text' => "The download errors seem to have been caused by some faulty workunits. Please let us know if this problem still occurs after a couple of days."
      ),
    array(
      'date' => "September 14, 2006 15:40:00",
      'title' => "",
      'text' => "Many people are currently experiencing download errors for certain input files (e.g. lpdb.prm, etc). We are finding out why this is happening. Keep an eye on the news for more info."
      ),
    array(
      'date' => "September 14, 2006 13:10:00",
      'title' => "",
      'text' => "We have finally validated some workunits: 18 all in all. Not many yet, but at least some, because we were getting worried :-) The reason of course is the 131 error for which we will deploy a solution today if the tests are successful."
      ),
    array(
      'date' => "September 14, 2006 03:20:00",
      'title' => "",
      'text' => "we've found a bug in the input file for charmm: a random seed is not properly doing what it is supposed to be doing and causes writing to one of the output files over and over; this output file is normally about 2kb in size, but because of this problem grows to way over 1 MB which the boinc client doesn't like and thus errors with -131. We'll fix this as soon as possible. All current wu's are affected."
      ),
    array(
      'date' => "September 13, 2006 19:40:00",
      'title' => "",
      'text' => "We'll close invited account creation soon for windows and linux machines. Intel Macs are still welcome as we don't have enough of them yet. Please write an email to dockingadmin@utep.edu if you have an Intel Mac and want to participate in the tests."
      ),
    array(
      'date' => "September 13, 2006 18:00:00",
      'title' => "",
      'text' => "The RSS feed has been fixed (thanks to Nicolas Alvarez!)."
      ),
    array(
      'date' => "September 13, 2006 15:00:00",
      'title' => "",
      'text' => "Revised estimate: our workunits currently take around 4 hours on an Intel P4 3GHz PC. We are working to get a better value for the estimated time shown on the GUI."
      ),
    array(
      'date' => "September 13, 2006 09:00:00",
      'title' => "",
      'text' => "Closed the account creation for now. We have enough windows users for testing. If you have an Intel-Mac or Linux machine write us an email at dockingadmin@utep.edu and we'll create an account for you. Please write down your comments, error reports and inputs in the forums and we'll get to the problems as soon as possible. Thanks!"
      ),
    array(
      'date' => "September 13, 2006 06:00:00",
      'title' => "",
      'text' => "RSS feed doesn't work correctly yet and there is a problem with sigs in the forum prefs. We will be checking these problems out."
      ),
    array(
      'date' => "September 13, 2006 01:00:00",
      'title' => "",
      'text' => "The website is being actively worked on. Please don't be surprised if things change all of a sudden. Also our workunits currently take around 1.5 hours on an Intel P4 3GHz PC. Fairly short, but that will change later."
      ),
    array(
      'date' => "September 12, 2006 23:00:00",
      'title' => "",
      'text' => "Our app currently runs on Windows, Mac-Intel and Linux. We are still ironing out some problems in the mac-ppc version."
      ),
    array(
      'date' => "September 12, 2006 22:30:00",
      'title' => "",
      'text' => "We are looking for alpha testers. Write an email to dockingadmin@utep.edu if you are interested."
      ),
    array(
      'date' => "September 11, 2006 16:00:00",
      'title' => "",
      'text' => "Docking@Home is preparing for alpha testing! User creation is disabled for now."
      )
      );

    ?>

