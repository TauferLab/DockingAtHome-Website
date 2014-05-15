<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
	display_page_top("Docking@Home Support: Frequently Asked Questions");
?>


<div class="section">
    <h4>General Questions</h4>
    <ul>
        <li><a href="#general1">Why am I getting an unrecoverable error for result 1tng_mod0001_xxx_xxxxxx_x?</a></li>
        <li><a href="#general2">I am continuously getting the message "There is work, but it has been committed to other platforms". Why is this happening?</a></li>
        <li><a href="#general3">My machine is continuously writing to the hard drive, why is this happening? </a></li>
        <li><a href="#general4">After the application stops with an error on my machine, there are huge file uploads (sometimes up to 35 MB or so). Why is this happening?</a></li>
        <li><a href="#general5">Why are results in a workunit computed by different app versions (5.03 and 5.04)? Because of this my results are invalid.</a></li>
        <li><a href="#general6">Can I run Docking@Home on my computer with the 64-bit BOINC core client?</a></li>
        <li><a href="#general7">How is Docking@Home using Homogeneous Redundancy?</a></li>
    </ul>
</div>
<div class="section">
    <h4>Charmm Questions</h4>
    <ul>
        <li><a href="#charm1">What is the current version of Charmm running on Docking@Home?</a></li>
        <li><a href="#charm2">Why are Windows machines running Charmm 5.03 and the others 5.02? </a></li>
        <li><a href="#charm3">Starting Charmm shows a run error. What is the problem?</a></li>
        <li><a href="#charm4">I have been receiving a message on my Linux machine where Charmm exits with code 1. Is there a fix to this problem?</a></li>
    </ul>
</div>
<hr class="centered" />
<div class="section">
    <h4>General Questions</h4>
    <p class="faq_question">
        <a name="general1" class="anchor">Why am I getting an unrecoverable error for result 1tng_mod0001_xxx_xxxxxx_x?</a>
    </p>
    <blockquote class="faq_answer">
        This error has been fixed since charm 5.02. It has been reported on Windows machines 
        only. The error was caused by a random seed that is not properly doing what it is supposed to be 
        doing. It writes to one of the output files over and over; this output file is normally about 2kb 
        in size, was growing much bigger than 1 MB, and that is something the boinc client doesn't like.
    </blockquote>
    <p class="faq_question">
        <a name="general2" class="anchor">I am continuously getting the message "There is work, but it has been committed to other platforms". Why is this happening?</a>
    </p>
    <blockquote class="faq_answer">
        BOINC uses an infeasible flag for 
        the results in the shared memory segment. The problem with the infeasible flag is that if a 
        computer that is too weak comes in and requests work it sets everything to infeasible in the 
        shared memory segment. This in turn means that the new computer that comes in looking for work 
        sees that everything is infeasible and just grabs the first workunit they find. Because D@H is 
        using homogenous redundancy (HR) this means that instead of work that has already been designated 
        to a particular os/processor being sent to that computer - any result will be sent to that 
        computer. This causes more workunits to be quickly assigned to a particular HR category and 
        although we eventually work through the shared memory segment results that are marked infeasible, 
        you still have to deal with the issue of most or all of your workunits in the shared memory 
        segment being marked with a HR. This usually results in one or more types of computers not being 
        able to receive work and the 'work is available for other platforms' message being sent out. 
        Please be patient: at some time there will be work again.
    </blockquote>
    <p class="faq_question">
        <a name="general3" class="anchor">My machine is continuously writing to the hard drive, why is this happening?</a>
    </p>
    <blockquote class="faq_answer">
        We are still working on the 
        excessive writing issue. It might take a couple of days to get our checkpointing fixed and 
        working correctly: currently checkpointing is done without looking at the user preference for 
        disk writes.
    </blockquote>
    <p class="faq_question">
        <a name="general4" class="anchor">After the application stops with an error on my machine, there are huge file uploads (sometimes up to 35 MB or so). Why is this happening?</a>
    </p>
    <blockquote class="faq_answer">
        See this <a href="http://docking.cis.udel.edu/community/forum/thread.php?id=116">thread</a> 
        for more details. The large file that gets uploaded is called charmm.out and is basically the 
        log file that the application uses to write information to. Normally, when the application exits 
        without error, this file only contains the string \'NO ERRORS\', but in the case of an error, 
        we would like to have this file back on the server so that we can better find out why our 
        application was not doing what it was supposed to do. We realize this file can grow very large 
        and we have enabled this feature only for this test phase where we need as much information as 
        possible to solve the problems we find with our app. Later on, this uploading will be disabled or 
        we will only send back the minimum amount of info. One of the main reasons that charmm.out can 
        grow really large is if your machine crashes or freezes when the application is in the middle of 
        writing checkpoint data to disk. After BOINC restarts the application, it will crash, because it 
        finds incomplete data in the file percentdone.str. This can even occur at 80 or 90% of crunching 
        time. We are looking at how to make checkpointing a more atomic operation so that this will not 
        happen as much anymore.
    </blockquote>
    <p class="faq_question">
        <a name="general5" class="anchor">Why are results in a workunit computed by different app versions (5.03 and 5.04)? Because of this my results are invalid.</a>
    </p>
    <blockquote class="faq_answer">
        According to the BOINC developers this is the normal behavior, but in our case not necessarily 
        the best behavior. We will try to find a solution for this problem soon so that it doesn't happen anymore 
        after future app upgrades. When all the distributed results have returned this problem should not occur 
        anymore.
    </blockquote>
    <p class="faq_question">
        <a name="general6" class="anchor">Can I run Docking@Home on my computer with the 64-bit BOINC core client?</a>
    </p>
    <blockquote class="faq_answer">
        Yes you can. The application you are downloading is an exact copy of the 32-bit 
        version though, which means that you shouldn't expect any speedup because of the fact you are running 64 
        bits.
    </blockquote>
    <p class="faq_question">
        <a name="general7" class="anchor">How is Docking@Home using Homogeneous Redundancy?</a>
    </p>
    <blockquote class="faq_answer">
        At the moment we have the following configured for homogeneous redundancy (HR):
        <ul>
            <li>Windows/Intel PII/III</li> 
            <li>Windows/Intel P4 and up</li> 
            <li>Windows/AMD K6</li> 
            <li>Windows/AMD K7 and up</li> 
            <li>Linux/Intel P4 and up</li> 
            <li>Linux/Intel PII/III and AMD K7 and up</li> 
            <li>Linux/AMD K6</li> 
            <li>Mac/Intel</li> 
            <li>Mac/PPC (not used yet)</li> 
        </ul>
        Some of the Intel Macs seem to give different results (maybe as a consequence of having 
        different Intel architectures?), but we haven't found the exact HR rules needed yet. This 
        means we have to change our HR continuously (and thus the boinc source code) as this is not 
        configurable as yet.
    </blockquote>
</div>
<hr class="centered" />
<div class="section">
    <h4>Charmm Questions</h4>
    <p class="faq_question">
        <a name="charm1" class="anchor">What is the current version of charm running on Docking@Home?</a>
    </p>
    <blockquote class="faq_answer">
        All of our current app versions can be found on 
        the <a href="/status/apps.php">Apps Page</a>.
    </blockquote>
    <p class="faq_question">
        <a name="charm2" class="anchor">Why are Windows machines running Charmm 5.03 and the others 5.02?</a>
    </p>
    <blockquote class="faq_answer">
        This is due to a bug fix that was affecting only windows machines.
    </blockquote>
    <p class="faq_question">
        <a name="charm3" class="anchor">Starting Charmm shows a run error. What is the problem?</a>
    </p>
    <blockquote class="faq_answer">
        This means that there is a communication problem between BOINC (in your computer) and 
        the science application (project's server). Heartbeat is used to verify that both sides are running, 
        most of the time the BOINC client just restarts the WU from the last checkpoint. For more information 
        you can check: <a href="http://boinc-wiki.ath.cx/index.php?title=No_heartbeat_from_core_client_-_exiting" target="_blank">http://boinc-wiki.ath.cx/index.php?title=No_heartbeat_from_core_client_-_exiting</a>.
    </blockquote>
    <p class="faq_question">
        <a name="charm4" class="anchor">I have been receiving a message on my Linux machine where charm exits with code 1. Is there a fix to this problem?</a>
    </p>
    <blockquote class="faq_answer">
        This has to do with the stacksize setting on your 
        machine which is for some distros (SuSE 9.3 and 10 for example) set to unlimited and for others 
        (FCx, Ubuntu, etc) set to a limited value like 10240. On the Bash and K shells your setting can 
        be seen by typing 'ulimit -s' in a terminal. With TC shell the command is 'limit'. To make the 
        Charmm 'exit 1' errors go away, please set the stacksize to unlimited using the command 
        'ulimit -s unlimited' before you start the BOINC manager or add it to your run_manager.sh and/or 
        run_client.sh start scripts in the BOINC directory. For Ubuntu, if you install BOINC from their 
        repository, please put this line in the script /etc/init.d/boinc-client. This is not saying that 
        Charmm will use all of your memory (it won't), but it gives us a little bit more space to do our 
        simulations correctly and without errors. Please let us know if this does not work for you. Of 
        course don't forget to restart your BOINC manager and resume the D@H project on your boincmgr 
        in case you suspended it before.
    </blockquote>
</div>

<hr class="centered" />
<p>Can't find what you are looking for? Check out <a href="otherresources.php">Other Resources</a></p>
<p>Go back to <a href="/support/">Docking@Home Support</a></p>
<?php display_page_bottom(); ?>
