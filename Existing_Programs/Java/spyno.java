import java.util.*;
public class spyno
{
	public static void main(String args[])
	{
		int a, pro=1, sum=0, val;
		Scanner sc=new Scanner(System.in);
		System.out.println("enter a number : ");
		int num=sc.nextInt();
		val=num;
		while (num > 0) 
        	{
			sum=sum+(num%10);
			pro=pro*(num%10);
			num=num/10;        			
        	}
       		if(pro==sum)
       		{
       			System.out.println("Spy Number");
       		}
       		else
       		{
       			System.out.println("Not Spy Number");
       		}
	}	
}
