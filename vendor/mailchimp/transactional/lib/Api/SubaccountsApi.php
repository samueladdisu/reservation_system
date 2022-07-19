<?php

/**
 * SubaccountsApi
 * PHP version 5
 *
 * @category Class
 * @package  MailchimpTransactional
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Mailchimp Transactional API
 *
 * No description provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: 1.0.47
 * Contact: apihelp@mailchimp.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.12
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace MailchimpTransactional\Api;

use MailchimpTransactional\ApiException;
use MailchimpTransactional\Configuration;
use MailchimpTransactional\HeaderSelector;
use MailchimpTransactional\ObjectSerializer;

/**
 * SubaccountsApi Class Doc Comment
 *
 * @category Class
 * @package  MailchimpTransactional
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class SubaccountsApi
{
    protected $Configuration;

    public function __construct(Configuration $config = null)
    {
        $this->config = $config ?: new Configuration();
    }

    /**
     * Add subaccount
     * Add a new subaccount.
     */
    public function add($body = [])
    {
        return $this->config->post('/subaccounts/add', $body);
    }
    /**
     * Delete subaccount
     * Delete an existing subaccount. Any email related to the subaccount will be saved, but stats will be removed and any future sending calls to this subaccount will fail.
     */
    public function delete($body = [])
    {
        return $this->config->post('/subaccounts/delete', $body);
    }
    /**
     * Get subaccount info
     * Given the ID of an existing subaccount, return the data about it.
     */
    public function info($body = [])
    {
        return $this->config->post('/subaccounts/info', $body);
    }
    /**
     * List subaccounts
     * Get the list of subaccounts defined for the account, optionally filtered by a prefix.
     */
    public function list($body = [])
    {
        return $this->config->post('/subaccounts/list', $body);
    }
    /**
     * Pause subaccount
     * Pause a subaccount&#39;s sending. Any future emails delivered to this subaccount will be queued for a maximum of 3 days until the subaccount is resumed.
     */
    public function pause($body = [])
    {
        return $this->config->post('/subaccounts/pause', $body);
    }
    /**
     * Resume subaccount
     * Resume a paused subaccount&#39;s sending.
     */
    public function resume($body = [])
    {
        return $this->config->post('/subaccounts/resume', $body);
    }
    /**
     * Update subaccount
     * Update an existing subaccount.
     */
    public function update($body = [])
    {
        return $this->config->post('/subaccounts/update', $body);
    }
}
