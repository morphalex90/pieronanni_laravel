// Isolated so app.tsx can dynamically import framer-motion's DOM animation
// features from a distinct module specifier than its static `m`/`LazyMotion`
// imports — this lets Rollup split the features into their own async chunk.
import { domAnimation } from 'framer-motion'

export default domAnimation
