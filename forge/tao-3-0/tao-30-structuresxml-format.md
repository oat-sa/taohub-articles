<!--
parent:
    title: TAO_3_0
author:
    - 'Aamir Rasheed'
created_at: '2014-09-19 10:36:32'
updated_at: '2014-09-19 14:06:21'
tags:
    - 'TAO 3 0'
-->

Tao 3.0 structures.xml format
=============================

TAO 3.0 and on introduces many changes to the structures.xml files, migration from old-style structures.xml is very straightforward.

HERE MIGRATION STEPS

***Do I have the legacy version of structures.xml:***
-----------------------------------------------------

The presence of <icon> child element of both <structure> element and <action> element indicates the new format.<br/>

Where as absence of many url attributes in the <tree> child element of the <trees> signals a legacy version of structures.xml

Check out above changes to see if you have the new format of structures.xml.

***Example***\
Here’s an example of what a legacy structures.xml file might look like:
-----------------------------------------------------------------------




        
            Create and design items and exercises.
            
                
                    
                        
                    
                    
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                    
                
                
                            
            
        

The new-style structures.xml might look like what is below.




        
            Create and design items and exercises.
            
            
                
                    
                        
                    
                    
                        
                            
                        
                        
                            
                        
                        
                            
                        
                        
                            
                        
                        
                            
                        
                        
                            
                        
                        
                            
                        
                        
                            
                        
                        
                            
                        
                        
                            
                        
                        
                            
                        
                        
                            
                        
                        
                            
                        
                        
                            
                        
                    
                
            
        

