# Results description

Results are stored in the `diagnostic_report` table.

Most of the thresholds and test requirements can be calibrated via platform configuration.

# Workstation performance

| Column | Content | Unit |
| -- | -- | -- |
| performance_min | minimum time to display an item | second |
| performance_max | maximum time to display an item | second |
| performance_sum | sum of performance test times | second |
| performance_count | number of execution of the performance test | |
| performance_average | average time to display an item | second |
| performance_median | median time to display an item | second |
| performance_variance | time to display an item variance | |

To evaluate the workstation performances, the Diagnostic tool render 3 reference items in a hidden part of the screen. 
This is done multiple times (`performance_count`). 

Sample items can be customised so they are representative of the planned assessment.

# Bandwidth

| Column | Content | Unit |
| -- | -- | -- |
| bandwidth_min | minimum detected bandwidth | Mbps |
| bandwidth_max | maximum detected bandwidth | Mbps |
| bandwidth_sum | sum of bandwidth detection tests | Mbps |
| bandwidth_count | number of downloaded samples during the test | |
| bandwidth_average | average detected bandwidth | Mbps |
| bandwidth_median | median detected bandwidth | Mbps |
| bandwidth_variance | detected bandwidth variance | |
| bandwidth_duration | bandwidth test duration | second |
| bandwidth_size | size of downloaded during the test | |

To estimate the available bandwidth for the workstation, the diagnostic tool download a defined number (`bandwidth_count`) of packets of various sizes. 
This number can be dynamically lowered if the detected bandwidth is very slow, so the tool does not overload the network.

The diagnostic tool is calibrated by default so a test taker needs 0.35 Mbps to 0.5 Mbps to pass a test. 
With this calibration, the necessary bandwidth (`bandwidth_average`) for 25 test takers taking the test simultaneously is between 8.75 Mbps and 12.5 Mbps.

# Upload speed

| Column | Content | Unit |
| -- | -- | -- |
| upload_max | maximum upload bandwidth | Mbps |
| upload_avg | average upload bandwidth | Mbps |

# Workstation configuration

| Column | Content |
| -- | -- | 
| workstation | workstation id |
| browser | browser name |
| browser_version | browser version |
| os | operating system name |
| os_version | operating system version |
| compatible | compatibility of OS / Browser combination |

You can interpret the `compatible` column in the following way:

| Value | Meaning |
| -- | -- |
| 0  | OS / Browser combination has been tested and does NOT work |
| 1  | OS / Browser combination has been tested |
| 2  | OS / Browser combination has NOT been tested |

# General information

| Column | Content |
| -- | -- |
| version | diagnostic tool version |
| id | diagnostic tool execution id |
| context_id | id of test center having run the diagnostic |
| login | diagnostic tool user login |
| user_id | TAO user id |
| ip | workstation IP |
| created_at | diagnostic tool execution date |