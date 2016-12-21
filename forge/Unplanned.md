<!--
author:
    - 'Patrick Plichart'
created_at: '2013-05-21 10:05:12'
updated_at: '2013-05-21 10:05:12'
-->

Unplanned Features
==================

TAO X.X (Unplanned) Distribution
--------------------------------

TAO X.X (Unplanned) Explore Graph databases
-------------------------------------------

OrientDB, MongoDB

TAO X.X (Unplanned) OATBox
--------------------------

Refactor the file system\
Split tao, generis and core framework

TAO X.X (Unplanned) Ubiquitous deployment
-----------------------------------------

###1. (Unplanned) Cloud deployment (SaaS capabilities){#1-unplanned-cloud-deployment-saas-capabilities}

Avoid the burden of maintaining costly and rapidly outdated IT infrastructure and systems, enable rapid and on-demand capacity scaling for large-scale or high throughput assessment\
Pay what you use. (resources usage as peaks)

-   Experiment TAO using Amazon virtual instances : Standard, Cluster High I/O
-   Evaluate, using our benchmarks, possible topologies on amazon depending on CBA settings.
-   Automatize the process to instanciate New VM on amazon using the Amazon API
-   Document the process to get Amazon hosting of TAO for our users.

###2. (Unplanned) Control Test Taker environment / legacy infrastructure support{#2-unplanned-control-test-taker-environment-legacy-infrastructure-support}

Deliver assessment within :\
- Locked down environment\
- Virtual machine\
- Usb Key : for both online (locked environment) and offline tests (then embedding servers). (candidate for 4.1)\
- LiveCd (control the operating system)

TAO X.X (Unplanned) Security
----------------------------

New security and identity management features such as: proctoring, secured thin web client, content and communication encryption, cheating detection tools, item exposure control, etc…\
Address High stakes and/or Summative assessment. Protect your Item Bank.

###1. Man in the middle{#1-man-in-the-middle}

Prevent third party entity to access data from network : Encrypt all communication channels and provide support for certificates installation.

-   TAO to TAO (several installations of TAO may exchange data through network
-   TAO to test taker

###3. Denial Of Service Resilience{#3-denial-of-service-resilience}

##4. Many ways to authenticate.{#4-many-ways-to-authenticate}

-   Proctoring. Define a user who will authenticate himselfs and be responsible for identifying the user taking the test
-   LDAP based authentication
-   OpenId
-   User defined algorithm. users may define an algorithm taht will check Login and Password
-   Anonymous testing
-   Subscribe and go
-   Data reliability : api would check if any transmitted data is correctly formed.

###5. Ensure the integrity of the test as seen by the test taker. A possibility for this would be to provide several delivery modes including a custom and independent web browser. Such controlled environment enables the use of specific assessment settings. Another possibility would be to experiment use of portable usb keys including the environment for test takers, Virtual machines and live CDs.{#5-ensure-the-integrity-of-the-test-as-seen-by-the-test-taker-a-possibility-for-this-would-be-to-provide-several-delivery-modes-including-a-custom-and-independent-web-browser-such-controlled-environment-enables-the-use-of-specific-assessment-settings-another-possibility-would-be-to-experiment-use-of-portable-usb-keys-including-the-environment-for-test-takers-virtual-machines-and-live-cds}

##6. Prevent test taker from accessing item definition or changing responses. Delegate matching on server side (ok).{#6-prevent-test-taker-from-accessing-item-definition-or-changing-responses-delegate-matching-on-server-side-ok}

##7. Avoid cheating : log analysis using patterns, learning neural networks: TESLA work{#7-avoid-cheating-log-analysis-using-patterns-learning-neural-networks-tesla-work}

##8. Item Exposure{#8-item-exposure}

Business intelligence and archiving modules\
Easily store and analyse loads of longitudinal data with evolving schemas

