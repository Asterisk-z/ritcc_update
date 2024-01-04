<?php

namespace App\Helpers;

class MailContents
{
    public static function createProfileSubject(): string
    {
        return "New Profile Created";
    }

    public static function createProfileMessage($profileName, $institutionName, $packageName): string
    {
        return "<p>A new profile has been created. Kindly approve.</p>

        <ul>
            <li><strong>Name:</strong> {$profileName}</li>
            <li><strong>Institution:</strong> {$institutionName}</li>
             <li><strong>Package:</strong> {$packageName}</li>
        </ul>
        ";
    }

    public static function deactivateProfileSubject(): string
    {
        return "Profile Deactivated";
    }

    public static function deactivateProfileMessage($profileName, $institutionName, $packageName, $reason): string
    {
        return "<p>A profile has been deactivated.</p>
           <ul>
            <li><strong>Name:</strong> {$profileName}</li>
            <li><strong>Institution:</strong> {$institutionName}</li>
            <li><strong>Package:</strong> {$packageName}</li>
            <li><strong>Reason:</strong> {$reason}</li>
        </ul>
        ";
    }

    public static function approveProfileCreateSubject(): string
    {
        return "Profile Approved";
    }

    public static function approveProfileCreateMessage($email, $password): string
    {
        return "<p>Your account has been successfully created. These are your login credentials:</p>
           <ul>
            <li><strong>Email:</strong> {$email}</li>
            <li><strong>Password:</strong> {$password}</li>
        </ul>
        ";
    }

    public static function rejectProfileCreateSubject(): string
    {
        return "Profile Rejected";
    }

    public static function rejectProfileCreateMessage($profileName, $institutionName, $packageName, $reason): string
    {
        return "<p>This profile has been rejected.</p>
           <ul>
            <li><strong>Name:</strong> {$profileName}</li>
            <li><strong>Institution:</strong> {$institutionName}</li>
            <li><strong>Package:</strong> {$packageName}</li>
            <li><strong>Reason:</strong> {$reason}</li>
        </ul>
        ";
    }

    public static function createCertificateSubject(): string
    {
        return "New Certificate Created";
    }

    public static function createCertificateMessage(): string
    {
        return "<p>A new certificate has been created. Kindly approve.</p>";
    }

    public static function approveCertificateCreateSubject(): string
    {
        return "Certificate Approved";
    }

    public static function approveCertificateCreateMessage(): string
    {
        return "<p>Certificate has been approved.</p>";
    }

    public static function rejectCertificateCreateSubject(): string
    {
        return "Certificate Rejected";
    }

    public static function rejectCertificateCreateMessage($reason): string
    {
        return "<p>Certificate has been approved.</p>
                <p>Reason:<strong>{$reason}</strong></p>";
    }

    public static function updateCertificateSubject(): string
    {
        return "Certificate Update";
    }

    public static function updateCertificateMessage(): string
    {
        return "<p>Certificate has been updated. Kindly approve.</p>";
    }

    public static function approveCertificateUpdateSubject(): string
    {
        return "Certificate Update Approved";
    }

    public static function approveCertificateUpdateMessage(): string
    {
        return "<p>Certificate update has been approved.</p>";
    }

    public static function rejectCertificateUpdateSubject(): string
    {
        return "Certificate Update Rejected";
    }

    public static function rejectCertificateUpdateMessage($reason): string
    {
        return "<p>Certificate has been rejected
        <ul>
        <il>Reason:<strong>{$reason}</strong></il>
        </ul>
        </p>";
    }

    public static function deleteCertificateSubject(): string
    {
        return "Certificate Delete";
    }

    public static function deleteCertificateMessage(): string
    {
        return "<p>Certificate has been deleted. Kindly approve.</p>";
    }

    public static function approveCertificateDeleteSubject(): string
    {
        return "Certificate Delete Approved";
    }

    public static function approveCertificateDeleteMessage(): string
    {
        return "<p>Certificate delete has been approved.</p>";
    }

    public static function rejectCertificateDeleteSubject(): string
    {
        return "Certificate Delete Rejected";
    }

    public static function rejectCertificateDeleteMessage($reason): string
    {
        return "<p>Certificate has been rejected
        <ul>
        <il>Reason:<strong>{$reason}</strong></il>
        </ul>
        </p>";
    }
}
