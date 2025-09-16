{{-- Expertise Detail Advantages Block --}}
@php
  $pill_text = get_field('advantages_pill_text') ?: 'Benefits';
  $main_title = get_field('advantages_main_title') ?: 'What benefits do our services provide';
  $description = get_field('advantages_description') ?: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...';
  $advantages = get_field('advantages_list') ?: [];

  // Default advantages if none are set
  if (empty($advantages)) {
      $advantages = [
          [
              'title' => 'Comprehensive insights',
              'description' => 'Get accurate and up-to-date information that helps you make informed decisions.',
              'icon_type' => 'checkmark'
          ],
          [
              'title' => 'Reduce errors and costs',
              'description' => 'Identify issues early to prevent surprises and save on corrections later.',
              'icon_type' => 'checkmark'
          ],
          [
              'title' => 'Faster decision making',
              'description' => 'Make smarter choices with better data and streamlined processes.',
              'icon_type' => 'checkmark'
          ]
      ];
  }
@endphp

<section id="voordelen" class="bg-t3ch-darkblue text-white py-20 {{ $block->className ?? '' }}">
    @if (is_admin())
        <div class="bg-gray-100 p-4 mb-5 border-l-4 border-blue-600">
            <strong>Expertise Detail Advantages Block</strong>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section: Two-Column Layout --}}
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-12 mb-16">
            {{-- Left Column: CTA Pill Tag --}}
            <div class="lg:w-60 flex-shrink-0">
                <div class="bg-t3ch-blue text-white px-6 py-3 rounded-full text-sm font-medium inline-block">
                    {{ $pill_text }}
                </div>
            </div>

            {{-- Right Column: Title and Description --}}
            <div class="flex-1">
                <h2 class="text-2xl lg:text-3xl font-semibold mb-6 leading-tight">
                    {{ $main_title }}
                </h2>
                <p class="text-base lg:text-lg leading-relaxed opacity-90">
                    {{ $description }}
                </p>
            </div>
        </div>

        {{-- Advantages List Section --}}
        <div class="space-y-8">
            @if (!empty($advantages))
                @foreach ($advantages as $index => $advantage)
                    <div class="flex flex-col sm:flex-row gap-4">
                        {{-- Title Row: Icon + Title --}}
                        <div class="flex items-center gap-4 sm:gap-6">
                            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center"
                                 aria-label="{{ ucfirst($advantage['icon_type'] ?? 'checkmark') }}" role="img">
                                @if(($advantage['icon_type'] ?? 'checkmark') === 'arrow')
                                    <img src="{{ Vite::asset('resources/images/icons/arrow-right.svg') }}" alt="Arrow" class="w-full h-full">
                                @elseif(($advantage['icon_type'] ?? 'checkmark') === 'star')
                                    <img src="{{ Vite::asset('resources/images/icons/star.svg') }}" alt="Star" class="w-full h-full">
                                @else
                                    <img src="{{ Vite::asset('resources/images/icons/check-square.svg') }}" alt="Checkmark" class="w-full h-full">
                                @endif
                            </div>
                            <h3 class="text-lg lg:text-xl font-semibold leading-snug">
                                {{ $advantage['title'] }}
                            </h3>
                        </div>

                        {{-- Advantage Description --}}
                        <div class="sm:ml-10">
                            <p class="text-base leading-relaxed opacity-80">
                                {{ $advantage['description'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
