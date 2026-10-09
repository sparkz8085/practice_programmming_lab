import java.util.*;
public class apply
{
	public static void main(String args[])
	{
		Scanner sc = new Scanner(System.in);
		System.out.println("enter number of cities = ");
		int size = sc.nextInt();
		sc.nextLine();
		String city[] = new String[size];
		int std[] = new int[size];
		for(int i=0; i<size; i++)
		{
			System.out.println("enter City = ");
			city[i] = sc.nextLine();

			System.out.println("enter STD code = ");
			std[i] = sc.nextInt();
			sc.nextLine();
		}
		System.out.println("enter city to search = ");
		String search = sc.nextLine();
		for(int i=0; i<size; i++)
		{
			if(city[i] == search)
			{
				System.out.println("STD code = " + std[i]);
			}
			else 
			{
				System.out.println("try again!!!");
			}
		}
	}
}
