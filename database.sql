CREATE TABLE `paymentcalculator` (
  `loanamount` int(20) NOT NULL,
  `interestrate` varchar(255) NOT NULL,
  `months` varchar(100) NOT NULL,
  `ortizationschedule` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `loanid` int(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`loanid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 2012-09-21 05:31:21
