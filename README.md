RedminePassage
==========
[![Build Status](https://travis-ci.org/AppioDigital/RedminePassage.svg?branch=master)](https://travis-ci.org/AppioDigital/RedminePassage)

This package provides functionality trough REST api provided by [redmine](http://www.redmine.org/projects/redmine/wiki/Rest_api).

Features
------------
- retrieve list of issue priorities, issue statuses, issue trackers
- retrieve a concrete project
- retrieve a list of issues for a given project
- retrieve an issue by id
- create/update an issue
- upload attachment to an issue

Installation
------------

The best way to install AppioDigital/RedminePassage is using [Composer](http://getcomposer.org/):

```sh
$ composer require appio-digital/redmine-passage
```

Usage
------------
To get list of issue priorities use:
```php
  // passed to guzzle client
  $options = ['X-Redmine-API-Key'] = 'api-key';
  /**
   * @var Appio\Redmine\Manager\PriorityManager $priorityManager
   * @var Appio\Redmine\Entity\Priority[] $priorities 
   */
  $priorities = $priorityManager->findAll($options);
```
To get list of issue statuses use:
```php
  /**
   * @var Appio\Redmine\Manager\StatusManager $statusManager
   * @var Appio\Redmine\Entity\Status[] $statuses 
   */
  $statuses = $statusManager->findAll($options);
```
To get list of issue trackers use:
```php
  /**
   * @var Appio\Redmine\Manager\TrackerManager $trackerManager
   * @var Appio\Redmine\Entity\Tracker[] $trackers 
   */
  $trackers = $trackerManager->findAll($options);
```
To get an id or name of an project use:
```php
  /**
   * @var Appio\Redmine\Manager\ProjectManager $projectManager 
   */
  $projectName = $projectManager->getName($options);
  $projectId = $projectManager->getId();
```
To get a list of issues for a project use:
```php
  /**
   * @var Appio\Redmine\Manager\IssueManager $issueManager 
   * @var Appio\Redmine\Entity\Issue[] $issues 
   * @var array $params http query parameters as paramName => paramValue
   */
  $issues = $issueManager->findAllByProject($projectId, $params, $options);
```
To get one issue use:
```php
  /**
   * @var Appio\Redmine\Manager\IssueManager $issueManager 
   * @var Appio\Redmine\Entity\Issue $issue
   */
  $issue = $issueManager->get($issueId, $options);
```
The issue manager uses a dto object or create/update operation of an issue.
```php
  /**
   * @var Appio\Redmine\Manager\IssueManager $issueManager 
   * @var Appio\Redmine\Entity\Issue $issue
   * @var Appio\Redmine\DTO\Issue $issue
   */
  $issue = $issueManager->save($dtoIssue, $options);
```
To add an attachment to an issue do the following:
```php
  /**
   * @var Appio\Redmine\Manager\UploadManager $uploadManager
   * @var Appio\Redmine\Entity\Upload $upload
   * @var Appio\Redmine\DTO\Issue $dtoIssue
   * @var Appio\Redmine\Entity\Issue $issue
   */
  $upload = $uploadManager->create($filePath, $clientFileName, $contentType, $description, $options);
  
  $dtoIssue->setUploads([$upload]);
  
  $issue = $issueManager->save($dtoIssue, $options);
```
