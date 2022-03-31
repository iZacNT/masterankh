<?php

namespace frontend\helpers;

use frontend\models\ContactForm;
use frontend\models\Job;
use frontend\models\Payment;
use frontend\models\User;
use Yii;
use yii\helpers\Url;

class EmailHelper
{
    /**
     * Inform message about the job(found, not found, fail).
     * @param Job $job
     * @return bool
     */
    public static function inform(Job $job): bool
    {
        $body = Yii::$app->view->renderFile('@frontend/mail/views/inform.php', [
            'job' => $job,
        ]);

        return Yii::$app->mailer->compose()
            ->setTo($job->user->second_email)
            ->setSubject('GeniePing Report - ' . $job->getStatusName())
            ->setHtmlBody($body)
            ->send();
    }

    /**
     * Acknowledgement message if reaching a notification limit.
     * @param Job $job
     * @return bool
     */
    public static function acknowledgement(Job $job): bool
    {
        $body = Yii::$app->view->renderFile('@frontend/mail/views/acknowledgement.php', [
            'job' => $job,
        ]);

        $subject = 'Genie Ping Inactive Target – Action Required Please Reactivate';

        return Yii::$app->mailer->compose()
            ->setTo($job->user->second_email)
            ->setSubject($subject)
            ->setHtmlBody(nl2br($body))
            ->send();
    }

    /**
     * Invoice for bought plan.
     * @param Payment $payment
     * @return bool
     */
    public static function invoice(Payment $payment): bool
    {
        $body = Yii::$app->view->renderFile('@frontend/mail/views/invoice.php', [
            'payment' => $payment,
        ]);

        $subject = 'Invoice from Genie Ping';

        return Yii::$app->mailer->compose()
            ->setTo($payment->user->second_email)
            ->setSubject($subject)
            ->setHtmlBody(nl2br($body))
            ->send();
    }

    /**
     * Target has expired.
     * @param Job $job
     * @return bool
     */
    public static function expiry(Job $job): bool
    {
        $body = Yii::$app->view->renderFile('@frontend/mail/views/expiry.php', [
            'job' => $job,
        ]);

        $subject = 'Your Genie Ping target has expired';

        return Yii::$app->mailer->compose()
            ->setTo($job->user->second_email)
            ->setSubject($subject)
            ->setHtmlBody(nl2br($body))
            ->send();
    }

    /**
     * Sending verification code after registration.
     * @param User $user
     * @param string $code
     * @return bool
     */
    public static function register(User $user, string $code): bool
    {
        $body = Yii::$app->view->renderFile('@frontend/mail/views/register.php', [
            'link' => Url::toRoute(['site/verify-email', 'code' => $code], true),
            'user' => $user,
        ]);


        return Yii::$app->mailer->compose()
            ->setTo($user->email)
            ->setSubject('E-Mail confirmation')
            ->setHtmlBody($body)
            ->send();
    }

    /**
     * Send email from contact form.
     * @param ContactForm $model
     * @param string $email
     * @return bool
     */
    public static function contactForm(ContactForm $model, string $email)
    {
        $body = Yii::$app->view->renderFile('@frontend/mail/views/contact-form.php', [
            'model' => $model,
        ]);

        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setSubject("Contact form submission: $model->name")
            ->setHtmlBody($body)
            ->send();
    }

    /**
     * Send test email to specified address.
     * @param string $email - email address to send
     * @param string $message
     * @param string $subject
     * @return bool
     */
    public static function test(string $email, string $message, string $subject = 'genieping.com'): bool
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setSubject($subject)
            ->setHtmlBody(nl2br($message))
            ->send();
    }
}
