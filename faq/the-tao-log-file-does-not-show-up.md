<!--
authors: [Patrick Plichart]
created_at: 2016-03-03
-->

# The TAO log file does not show up ? 

- is the file location writable by www-data/http?
- does the directory exist all?

Also, check `/config/generis/log.conf.php`, you may have returned a simple array instead of the 2-depths required levels.
    
    // Wrong
    return array(
		'class'     => 'SingleFileAppender',
		'threshold' => 4,
		'file'      => '/tmp/myloglocation/',
		'format'    => '%m'
	);
	

    // Right
	return array(
		array(
			'class'     => 'SingleFileAppender',
			'threshold' => 4,
			'file'      => '/tmp/myloglocation/',
			'format'    => '%m'
		)
	);
	