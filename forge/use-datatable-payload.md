<!--
author:
    - 'Aleh Hutnikau'
created_at: '2016-10-11 17:12:45'
updated_at: '2016-10-11 17:12:45'
-->

Usage of DatatablePayload
=========================

DatatablePayload is used to generate json data for datatable.js component.

DatatablePayload supports multiple filtering and easy to use.

Basic usage:
------------

-   Create concrete class which extends *oat\\tao\\model\\datatable\\AbstractDatatablePayload*:<br/>

    https://github.com/oat-sa/tao-core/blob/develop/models/classes/datatable/implementation/AbstractDatatablePayload.php

<!-- -->

-   Two abstract methods should be implemented:

1\. *AbstractDatatablePayload::getPropertiesMap()* - list of properties and their aliases (practically this is the list of columns represented in datatable).<br/>

Example:

    protected function getPropertiesMap()
    {
        return [
            'firstname' => 'http://www.tao.lu/Ontologies/generis.rdf#userFirstName',
            'lastname' => 'http://www.tao.lu/Ontologies/generis.rdf#userLastName',
            'identifier' => 'http://www.tao.lu/Ontologies/mpart.rdf#studentid',
        ];
    }

2\. *AbstractDatatablePayload::getType()* - Class uri to search.<br/>

Example:

    protected function getType()
    {
        return 'http://www.tao.lu/Ontologies/mpart.rdf#Student';
    }

To get datatable payload just call *DatatablePayload::getPayload()* method. All necessary data (such as filter data, page number, number of rows, ordering etc.) will be automatically fetched from request and datatable json will be generated. Usage example in controller:

    class StudentController
    {
    ...
        public function data()
        {
            $data = new StudentDatatable();
            $this->returnJson($data->getPayload(), 200);
        }
    ...
    }

*AbstractDatatablePayload* class implements *JsonSerializable* interface so it can be used even easier:

    class StudentController
    {
    ...
        public function data()
        {
            $this->returnJson(new StudentDatatable(), 200);
        }
        ...
    }

Make sure that you configured multiple filter strategy (*filterStrategy: ’multiple’*) in datatable on client side:

    $studentsList.datatable({
        url: helpers._url('data', 'Student', 'taoMpArt'),
        filter: true,
        filterStrategy: 'multiple',
        model: [{
            id: 'identifier',
            label: __('ID Number'),
            sortable: true,
            filterable: true
        }, {
            id: 'firstname',
            label: __('First Name'),
            sortable: true,
            filterable: true
        }, {
            id: 'lastname',
            label: __('Last Name'),
            sortable: true,
            filterable: true
        }]
    });
