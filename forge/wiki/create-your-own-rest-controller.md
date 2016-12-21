<!--
author:
    - 'Rex Wallen Tan'
created_at: '2016-03-13 16:47:51'
updated_at: '2016-03-13 16:50:43'
tags:
    - Wiki
-->

Create your own REST Controller
===============================

When you are accessing TAO 3.0, you may notice that the REST Controllers have not yet been ported from TAO 2.6 (this may change in succeeding versions).

Step 1: Create a new PHP file such as TestController.php in the actions folder of your MODULE
---------------------------------------------------------------------------------------------

    class TestController extends \tao_actions_CommonRestModule
    {

        public function __construct(){
                parent::__construct();
        }

        public function index()
        {
            $data = "Hello world";
            $this->returnSuccess($data);
        }

    }

Step 2: Check you can access the TestController you have created with a URL such as
-----------------------------------------------------------------------------------

http://localhost/projects/tao/(YOUR MODULE HERE)/TestController

Step 3: Create a separate PHP file called Test.php (Check you have CURL installed) which will access your new REST Controller
-----------------------------------------------------------------------------------------------------------------------------

     Test 
    Testing

Step 4: Access Test.php through your Browser
--------------------------------------------

You should see something similar to {[success](../resources/true,"data":"Hello) world“,”version“:”3.0.0"}200

Create your own REST Controller
===============================

When you are accessing TAO 3.0, you may notice that the REST Controllers have not yet been ported from TAO 2.6 (this may change in succeeding versions).

Step 1: Create a new PHP file such as TestController.php in the actions folder of your MODULE
---------------------------------------------------------------------------------------------

    class TestController extends \tao_actions_CommonRestModule
    {

        public function __construct(){
                parent::__construct();
        }

        public function index()
        {
            $data = "Hello world";
            $this->returnSuccess($data);
        }

    }

Step 2: Check you can access the TestController you have created with a URL such as
-----------------------------------------------------------------------------------

http://localhost/projects/tao/(YOUR MODULE HERE)/TestController

Step 3: Create a separate PHP file called Test.php (Check you have CURL installed) which will access your new REST Controller
-----------------------------------------------------------------------------------------------------------------------------

     Test
    Testing

Step 4: Access Test.php through your Browser
--------------------------------------------

You should see something similar to {[success](../resources/true,"data":"Hello) world“,”version“:”3.0.0"}200


