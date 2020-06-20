# Magento 2  Module for auto deleting logs #

# Warning # 
Use project at your own risk ,the owners or contributors will not be held liable for any damages of any sort caused by using this code
This code is an illustration of how a log auto cleaner can be implemented

# How it works 
The module runs a cron every hour to check the size of the log files and if the size of the files is equal or greater the size(MB) set in the admin 
It will removing the logs depending on the selected options
# Option 1
Delete - It will delete the logs
# Option 2
Email BackUp and Delete - It will send a zipped file of the logs to an email set by the admin and then delete the logs 
# Option 3
Cloud BackUp and Delete - It will send a zipped file of the logs to the google cloud account set by the admin and then delete the logs 


# For Cloud BackUp#

# Google Api Key#
Google Cloud Platform -> IAM -> Credentials -> Service Account 
# Project ID#
 Get this key from credential.json 
# Project Bucket Name
Google Cloud Platform -> Storage -> Create Bucket
 