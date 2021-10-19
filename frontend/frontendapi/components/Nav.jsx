import { useState, useEffect } from 'react';

import { NavLink } from '.';
import { userService } from 'services';



export function Nav() {
    const [user, setUser] = useState(null);

    useEffect(() => {
        const subscription = userService.user.subscribe(x => setUser(true));
        return () => subscription.unsubscribe();
    }, [setUser]);

    function logout() {
        userService.logout();
    }

    // only show nav when logged in
    if (!user) return null;
    
    return (
	<nav className="bg-white shadow-lg">
		<div className="max-w-6xl mx-auto px-4">
			<div className="flex justify-between">
				<div className="flex space-x-7">
					<div>

					</div>
					<div className="hidden md:flex items-center space-x-1">
						<NavLink
							exact href="/"
							className="py-4 px-2 text-green-500 hover:border-b-4 font-semibold "
							>Home 
            </NavLink>
            <NavLink
							exact href="schedule"
							className="py-4 px-2 text-green-500 hover:border-b-4  font-semibold "
							>Full Schedule 
            </NavLink>
            <NavLink
							exact href="myschedule"
							className="py-4 px-2 text-green-500 hover:border-b-4  font-semibold "
							>My Schedule 
            </NavLink>
            <a href="#" onClick={logout} className="py-4 px-2 text-green-500 hover:border-b-4 font-semibold">Logout</a>
					</div>
				</div>
			</div>
		</div>
	</nav>
    );
}