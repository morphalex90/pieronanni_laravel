import '../../css/_synt.scss'

export default function Synt() {
    // 15 vertical lines: 7 mirrored left, 1 center, 7 mirrored right.
    // All transforms live in _synt.scss and are selected by nth-child.
    const verticalLines = Array.from({ length: 15 })

    // 8 horizontal lines; animation-delay lives in _synt.scss (nth-child).
    const horizontalLines = Array.from({ length: 8 })

    return (
        <div className="synt">
            <div className="synt__container">
                <div className="synt__background"></div>

                <div className="synt__bottom">
                    {verticalLines.map((_, i) => (
                        <div key={i} className="line__vertical" />
                    ))}

                    {horizontalLines.map((_, i) => (
                        <div key={i} className="line__horizontal"></div>
                    ))}
                </div>
            </div>
        </div>
    )
}
