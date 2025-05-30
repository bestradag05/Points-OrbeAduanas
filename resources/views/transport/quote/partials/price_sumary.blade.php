{{-- price_summary.blade.php --}}
<div class="direct-chat-msg right">
  <div class="direct-chat-text bg-light">
    <strong>Transporte:</strong> S/ {{ number_format($quote->cost_transport,2) }}
  </div>
</div>
@foreach($transportConcepts as $tc)
  <div class="direct-chat-msg right">
    <div class="direct-chat-text bg-light">
      <strong>{{ $tc->name }}:</strong>
      S/ {{ number_format($tc->value_concept,2) }}
    </div>
  </div>
@endforeach
