import { useRouter } from 'next/router';
import PropTypes from 'prop-types';

import { Link } from '.';



NavLink.propTypes = {
    href: PropTypes.string.isRequired,
    exact: PropTypes.bool
};

NavLink.defaultProps = {
    exact: false
};

export function NavLink({ children, href, exact, ...props }) {
    const { pathname } = useRouter();
    const isActive = exact ? pathname === href : pathname.startsWith(href);
    
    if (isActive) {
        props.className += ' border-green-500 border-b-4';
    }

    return <Link href={href} {...props}>{children}</Link>;
}