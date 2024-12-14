import '../../css/_synt.scss'

export default function Synt() {
    const firstStep = 8

    const horizontalLines = []
    for (let i = 4; i >= 0.5; (i = i - 0.5)) {
        horizontalLines.push(i)
    }

    function translateAmount(n: number) {
        let total = 0
        for (let i = 1; i <= n; i++) {
            total = total + (firstStep * (0.975 ** n))
        }
        return total * 8
    }

    function turnAmount(n: number) {
        return -(0.25 * (0.65 ** n) - 0.25);
    }

    return (
        <div className="synt">
            <div className="synt__container">
                <div className="synt__background"></div>

                <div className="synt__bottom">
                    <div className="line__vertical" style={{ transform: 'translate(-' + translateAmount(7) + 'px,0) rotate( ' + turnAmount(7) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(-' + translateAmount(6) + 'px,0) rotate( ' + turnAmount(6) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(-' + translateAmount(5) + 'px,0) rotate( ' + turnAmount(5) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(-' + translateAmount(4) + 'px,0) rotate( ' + turnAmount(4) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(-' + translateAmount(3) + 'px,0) rotate( ' + turnAmount(3) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(-' + translateAmount(2) + 'px,0) rotate( ' + turnAmount(2) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(-' + translateAmount(1) + 'px,0) rotate( ' + turnAmount(1) + 'turn)' }} />

                    <div className="line__vertical" />

                    <div className="line__vertical" style={{ transform: 'translate(' + translateAmount(1) + 'px,0) rotate(-' + turnAmount(1) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(' + translateAmount(2) + 'px,0) rotate(-' + turnAmount(2) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(' + translateAmount(3) + 'px,0) rotate(-' + turnAmount(3) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(' + translateAmount(4) + 'px,0) rotate(-' + turnAmount(4) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(' + translateAmount(5) + 'px,0) rotate(-' + turnAmount(5) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(' + translateAmount(6) + 'px,0) rotate(-' + turnAmount(6) + 'turn)' }} />
                    <div className="line__vertical" style={{ transform: 'translate(' + translateAmount(7) + 'px,0) rotate(-' + turnAmount(7) + 'turn)' }} />

                    {horizontalLines.map(line =>
                        <div key={line} className="line__horizontal" style={{ animationDelay: '-' + line + 's' }}></div>
                    )}

                </div>
            </div>
        </div>
    )
}
