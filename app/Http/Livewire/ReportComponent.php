<?php

namespace App\Http\Livewire;

use App\Models\ReportedGig;
use Livewire\Component;

class ReportComponent extends Component
{
    public $gig;
    public $reason;

    public function mount($gig)
    {
        $this->gig=$gig;
    }
    public function render()
    {
        return view('livewire.report-component');
    }

    public function report()
    {

         try {

            // test login
            if (auth()->guest()) {
                
                $this->dispatchBrowserEvent('alert',["message" => 'please login or register to report this gig',"type"=> "info"]);
                return;
            }

            // test gig owner
            if ($this->gig->user_id === auth()->id()) {
                
                $this->dispatchBrowserEvent('alert',["message" =>"you can't report this gig","type"=> "info"]);
                return;
            }

            $rules    = $this->validate([
                'reason'  => 'required|min:6|max:500'
            ]);
            
            //  if user already reported this gig
            $Reported = ReportedGig::where('gig_id', $this->gig->id)->where('user_id', auth()->id())->first();

            if ($Reported) {
            
                $this->reset('reason');

                $this->dispatchBrowserEvent('alert',["message" => ' already reported this gig ',"type"=> "info"]);
                return;
            }

            //  add report
            ReportedGig::create([
                'gig_id'  => $this->gig->id,
                'user_id' => auth()->id(),
                'reason'  => $this->reason
            ]);

            // Reset form
            $this->reset('reason');
            $this->dispatchBrowserEvent('closemodal');
            // Success
            $this->dispatchBrowserEvent('alert',["message" =>'gig reported successfully',"type"=> "success"]);


        } catch (\Illuminate\Validation\ValidationException $e) {

            $this->dispatchBrowserEvent('alert',[
                "message" => __('form validation error'),
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('alert',["message" =>'something went wrong',"type"=> "error"]);

            throw $th;
        }
    }
    
}
