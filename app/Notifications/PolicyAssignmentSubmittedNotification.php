<?php

namespace App\Notifications;

use App\Models\PolicyAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PolicyAssignmentSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $policyAssignment;

    public function __construct(PolicyAssignment $policyAssignment)
    {
        $this->policyAssignment = $policyAssignment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Policy Assignment Submitted')
            ->line('A new policy assignment has been submitted.')
            ->line('Policy Assignment ID: ' . $this->policyAssignment->id)
            ->action('View Policy Assignment', url('/policy-assignments/' . $this->policyAssignment->id))
            ->line('Thank you for using our application!');
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // public function toArray($notifiable)
    // {
    //     return [
    //         'message' => 'A new policy assignment has been submitted.',
    //         'policy_assignment_id' => $this->policyAssignment->id,
    //         'link' => '/policy-assignments/' . $this->policyAssignment->id,
    //     ];
    // }
}
