<!--
author:
    - 'Christophe Garcia'
created_at: '2016-07-28 11:22:10'
updated_at: '2016-08-04 17:10:09'
-->

Use complex search API
======================

configuration
-------------

in config/generis/complexSearch.conf :


    return new oat\oatbox\search\ComplexSearchService (
            [
                    'shared'    => 
                        [
                            'search.query.query'      => false,
                            'search.query.builder'    => false,
                            'search.query.criterion'  => false,
                            'search.tao.serialyser'   => false,
                            'search.tao.result'       => false,
                        ],
                    'invokables' => 
                        [
                            'search.query.query'      =>  '\\oat\\search\\Query',
                            'search.query.builder'    =>  '\\oat\\search\\QueryBuilder',
                            'search.query.criterion'  =>  '\\oat\\search\\QueryCriterion',
                            'search.driver.postgres'  =>  '\\oat\\search\\DbSql\\Driver\\PostgreSQL',
                            'search.driver.mysql'     =>  '\\oat\\search\DbSql\\Driver\\MySQL',
                            'search.driver.tao'       =>  '\\oat\\oatbox\\search\\driver\\TaoSearchDriver',
                            'search.tao.serialyser'   =>  '\\oat\\search\\DbSql\\TaoRdf\\UnionQuerySerialyser',
                            'search.factory.query'    =>  '\\oat\\search\\factory\\QueryFactory',
                            'search.factory.builder'  =>  '\\oat\\search\\factory\\QueryBuilderFactory',
                            'search.factory.param'    =>  '\\oat\\search\\factory\\QueryParamFactory',
                            'search.tao.gateway'      =>  '\\oat\\oatbox\\search\\GateWay',
                            'search.tao.result'       =>  '\\oat\\oatbox\\search\\TaoResultSet',
                        ],
                    'abstract_factories' => 
                        [
                            '\\oat\\search\\Command\\OperatorAbstractfactory',
                        ],
                    'services' => 
                        [
                            'search.options' =>
                                [
                                    'table'    => 'statements',
                                    'driver'   => 'taoRdf',
                                ]
                        ]

                ]
            );

service basic usage :
---------------------

### criteria basic search :

search every items with label equal to ‘foo’.


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);
    $queryBuilder = $search->query()

    $myquery = $queryBuilder->newQuery()->add(RDFS_LABEL)->equals('foo');

    $queryBuilder->setCriteria($myquery);

    $result = $search->getGateway()->search($queryBuilder);

### search by type :

search every test takers.


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);
    $queryBuilder = $search->query();
    $query = $search->searchType( $queryBuilder , 'http://www.tao.lu/Ontologies/TAOSubject.rdf#Subject' , true);
    $queryBuilder->setCriteria($query);
    $result = $search->getGateway()->search($queryBuilder);

add criteria :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);

    $queryBuilder = $search->query();
    $query = $search->searchType($queryBuilder , 'http://www.tao.lu/Ontologies/TAOSubject.rdf#Subject' , true)
                     ->add(RDFS_LABEL)
                     ->contains('foo');

    $queryBuilder->setCriteria($query);

    $result = $search->getGateway()->search($queryBuilder);

### language search :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);
    $queryBuilder = $search->query();
    $query = $search->setLanguage($queryBuilder , $userLanguage , $defaultLanguage)
                     ->add(RDFS_LABEL)
                     ->contains('foo');

    $queryBuilder->setCriteria($query);

    $result = $search->getGateway()->search($queryBuilder);

### multiple criteria search :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);

    $queryBuilder = $search->query();
    $query = $queryBuilder->newQuery()
                     ->add(RDFS_LABEL)
                     ->contains('foo')
                     ->add(RDFS_COMMENT)
                     ->contains('bar');


    $queryBuilder->setCriteria($query);

    $result = $search->getGateway()->search($queryBuilder);

### multiple values on same criterion search :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);

    $queryBuilder = $search->query();
    $query = $queryBuilder->newQuery()
                     ->add(RDFS_LABEL)
                     ->contains('foo')
                     ->addOr('bar');

    $queryBuilder->setCriteria($query);
    $result = $search->getGateway()->search($queryBuilder);

with different operator :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);

    $queryBuilder = $search->query();
    $query = $queryBuilder->newQuery()
                     ->add(RDFS_LABEL)
                     ->contains('foo')
                     ->addAnd('bar' , SupportedOperatorHelper::BEGIN);

    $queryBuilder->setCriteria($query);
    $result = $search->getGateway()->search($queryBuilder);

### use OR :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);

    $queryBuilder = $search->query();

    $query = $queryBuilder->newQuery()
                     ->add(RDFS_LABEL)
                     ->begin('a')

    $queryOr = $queryBuilder->newQuery()
                     ->add(RDFS_LABEL)
                     ->begin('z');

    $queryBuilder->setCriteria($query)->setOr($queryOr);
    $result = $search->getGateway()->search($queryBuilder);


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);

    $queryBuilder = $search->query();

    /**
    * search for anything with a label begins by a AND comment contains "foo" and comment contains "bar"
    * OR
    * anything with a label begins by b AND comment contains "titi" and comment contains "toto"
    *
    **/
    $queryBuilder = $search->query();

    $query = $queryBuilder->newQuery()
                     ->add(RDFS_LABEL)->begin('a')
                     ->add(RDFS_COMMENT)->contains('foo')  
                     ->add(RDFS_COMMENT)->contains('bar')          


    $queryOr = $queryBuilder->newQuery()
                     ->add(RDFS_LABEL)->begin('z')
                     ->add(RDFS_COMMENT)->contains('titi')  
                     ->add(RDFS_COMMENT)->contains('toto');

    $queryBuilder->setCriteria($query)->setOr($queryOr);
    $result = $search->getGateway()->search($queryBuilder);

Criteria are grouped by AND operator :

to search test takers which label begin by ‘a’ or begin by ‘z’ :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);

    /**
    * a test taker with label begins by 'a'
    *
    * or
    *
    * a test taker with comment begins by 'b'
    **/

    $queryBuilder = $search->query();

    $query = $search->searchType($queryBuilder ,'http://www.tao.lu/Ontologies/TAOSubject.rdf#Subject' , true)
                     ->add(RDFS_LABEL)
                     ->begin('a');

    $queryOr = $search->searchType( $queryBuilder ,'http://www.tao.lu/Ontologies/TAOSubject.rdf#Subject' , true)
                     ->add(RDFS_COMMENT)
                     ->begin('z');


    $queryBuilder->setCriteria($query)->setOr($queryOr);

    $result = $search->getGateway()->search($queryBuilder);


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);

    /**
    * a test taker with label begin by 'a' or label begin by 'b'
    **/

    $queryBuilder = $search->query();

    $query = $search->searchType($queryBuilder ,'http://www.tao.lu/Ontologies/TAOSubject.rdf#Subject' , true)
                     ->add(RDFS_LABEL)
                     ->begin('a')
                     ->addOr('b');

    $queryBuilder->setCriteria($query);

    $result = $search->getGateway()->search($queryBuilder);

supported operators :
---------------------

### operators list :

  Constant               string value   SQL operator                     Comment
  ---------------------- -------------- -------------------------------- -----------------------------------------
  EQUAL                  ‘equals’       ‘=’                              
  DIFFERENT              ‘notEqual’     ‘!=’                             
  GREATER\_THAN          ‘gt’           ‘\>’                             
  GREATER\_THAN\_EQUAL   ‘gte’          ‘\>=’                            
  LESSER\_THAN           ‘lt’           ‘\<’                             
  LESSER\_THAN\_EQUAL    ‘lte’          ‘\<=’                            
  BETWEEN                ‘between’      ‘BETWEEN ’value1’ AND ‘value2’   value must be an array with two indexes
  IN                     ‘in’           IN (‘1’ ,‘3’ , ‘5’ )             value must be an array
  MATCH                  ‘match’        LIKE ‘value’                     
  CONTAIN                ‘contains’     LIKE ‘value’                     
  BEGIN\_BY              ‘begin’        LIKE ‘value%’                    

use oat\\search\\helper\\SupportedOperatorHelper to see all supported operators

### usage examples :

**simple value example :**


    $query->add(RDFS_LABEL)->equals('foo');
    $query->add(RDFS_LABEL)->gte(1);

OR


    $query->addCriterion(RDFS_LABEL , SupportedOperatorHelper::EQUAL , 'foo');
    $query)->addCriterion(RDFS_LABEL , SupportedOperatorHelper::GREATER_THAN_EQUAL , 1);

**between value example :**


    $query->add(RDFS_LABEL)->between(1 , 10);

OR


    $query->add(RDFS_LABEL)->between([1 , 10]);

OR


    $query->addCriterion(RDFS_LABEL,SupportedOperatorHelper::BETWEEN , [1 , 10]);

**IN value example :**


    $query->add(RDFS_LABEL)->in(1 , 5 , 10);

OR


    $query->add(RDFS_LABEL)->in([1 , 5 , 10]);

OR


    $query->addCriterion( RDFS_LABEL ,SupportedOperatorHelper::IN , [1 , 5 , 10]);

sorting Query :
---------------

Sort method is available on QueryBuilder :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);
    $queryBuilder = $search->query()->sort(
    [
    RDFS_LABEL => 'asc'
    ]
    );

    $query = $queryBuilder->add(RDFS_COMMENT)->contains('foo');
    $queryBuilder->setCriteria($query);

    $result = $search->getGateway()->search($queryBuilder);

Example for muliple sort :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);

    $queryBuilder = $search->query();

    $query = $queryBuilder->add(RDFS_COMMENT)->contains('foo');

    $queryBuilder->setCriteria($query)->sort(
    [
    RDFS_LABEL => 'asc',
    RDFS_COMMENT => 'desc',
    ]
    );
    $result = $search->getGateway()->search($queryBuilder);

Limit and Offset :
------------------

limit method is also available on QueryBuilder :

get 10 results :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);


    $query = $queryBuilder->newQuery()->add(RDFS_COMMENT)->contains('foo');

    $queryBuilder->setCriteria($query);

    $result = $search->getGateway()->search($queryBuilder)->setLimit(10);

get 10 results offset 5 :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);
    $queryBuilder = $search->query()->setLimit(10)->setOffset(5);

    $query = $queryBuilder->newQuery()->add(RDFS_COMMENT)->contains('foo');

    $queryBuilder->setCriteria($query);

    $result = $search->getGateway()->search($queryBuilder);

\> **NB : offset without limit is ignored**

Gateway :
---------

gateway is the highter component of complex search.<br/>

It provide query builder and it execute query using default database driver.

### only get number of result :

to get query number of result use count method :


    $total = $search->getGateway()->count($queryBuilder);

### debugging :

to debug query use printQuery method :


    $search->getGateway()->serialyse($queryBuilder);
    $search->getGateway()->printQuery();

Result Set :
------------

a result set is returned by gateWay search method’s.<br/>

It’s an arrayIterator adding total method which return full number for your query .

Each entry of result set is a tao resource Object.

### basic usage :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);

    $queryBuilder = $search->query();
    $query = $queryBuilder->newQuery()->add(RDFS_COMMENT)->contains('foo');

    $queryBuilder->setCriteria($query);
    $result = $search->getGateway()->search($queryBuilder)

    foreach($result as $resource) {
           echo $resource->getLabel();
    }


### use total :


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);
    $queryBuilder = $search->query();
    $query = $queryBuilder->newQuery()->add(RDFS_COMMENT)->contains('foo');

    $queryBuilder->setCriteria($query);
    $result = $search->getGateway()->search($queryBuilder);

    echo $result->total(); 
    echo $result->count();

    // 18
    // 18


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);
    $queryBuilder = $search->query();
    $query = $queryBuilder->newQuery()->add(RDFS_COMMENT)->contains('foo');

    $queryBuilder->setCriteria($query)->setLimit(5);
    $result = $search->getGateway()->search($queryBuilder);

    echo $result->total(); 
    echo $result->count();

    // 18
    // 5


    $search = $this->getServiceManager()->get(\oat\oatbox\search\ComplexSearchService::SERVICE_ID);
    $queryBuilder = $search->query();
    $query = $queryBuilder->newQuery()->add(RDFS_COMMENT)->contains('foo');

    $queryBuilder->setCriteria($query)->setLimit(5)->setOffset(10);
    $result = $search->getGateway()->search($queryBuilder);

    echo $result->total(); 
    echo $result->count();

    // 18
    // 3


