import { useState } from 'react'
import { showImagePlaceholder } from '@/lib/utils'
import type { ImageType } from '@/types'

import '../../css/_image-slider.scss'

export default function ImageSlider({ images, alt }: { images: ImageType[]; alt: string }) {
    const [currentIndex, setCurrentIndex] = useState(0)
    const hasMultipleImages = images.length > 1

    const goTo = (index: number) => setCurrentIndex((index + images.length) % images.length)

    return (
        <div className="image-slider" role="region" aria-roledescription="carousel" aria-label={`${alt} screenshots`}>
            <div className="image-slider__viewport">
                <div className="image-slider__track" style={{ transform: `translateX(-${currentIndex * 100}%)` }}>
                    {images.map((image, index) => (
                        <div
                            key={image.id}
                            className="image-slider__slide"
                            role="group"
                            aria-roledescription="slide"
                            aria-label={`${index + 1} of ${images.length}`}
                            aria-hidden={index !== currentIndex}
                        >
                            <img
                                src={image.url}
                                alt={`${alt} screenshot ${index + 1}`}
                                loading={index === 0 ? 'eager' : 'lazy'}
                                onError={showImagePlaceholder}
                            />
                        </div>
                    ))}
                </div>
            </div>

            {hasMultipleImages && (
                <>
                    <button
                        type="button"
                        className="image-slider__arrow image-slider__arrow--prev"
                        onClick={() => goTo(currentIndex - 1)}
                        aria-label="Previous screenshot"
                    >
                        &#8249;
                    </button>
                    <button
                        type="button"
                        className="image-slider__arrow image-slider__arrow--next"
                        onClick={() => goTo(currentIndex + 1)}
                        aria-label="Next screenshot"
                    >
                        &#8250;
                    </button>
                </>
            )}
        </div>
    )
}
